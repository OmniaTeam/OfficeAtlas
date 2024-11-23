<?php

namespace App\Service\Employee;

use App\Entity\Employee;
use App\Entity\Office;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class EmployeeService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    )
    {
    }

    public function getAllEmployees(): array
    {
        return $this->entityManager->getRepository(Employee::class)->findAll();
    }

    public function getEmployeesByPagination(int $page, int $perPage):?array
    {
        $employeeRepository = $this->entityManager->getRepository(Employee::class);
        $total = $this->entityManager->getRepository(Employee::class)->count([]);
        if ($page < 1) {
            $page = 1;
        }
        $pagination = [
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page,
        ];
        $employees = $employeeRepository->findBy([], limit: $perPage, offset: $perPage*($page - 1));
        $employeesArr = $this->serializer->normalize($employees, context: [
            AbstractNormalizer::CALLBACKS => [
                'office' => function ($office) {
                    return $office instanceof Office ? [
                        'id' => $office->getId(),
                        'name' => $office->getName(),
                    ] : null;
                }
            ],
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                'equipmentCopies',
                'requests',
                'workspaces',
                'claim',
            ]
        ]);
        return [
            "pagination" => $pagination,
            "data" => $employeesArr
        ];
    }

    public function getEmployeeById(int $id): ?Employee
    {
        $employee = $this->entityManager->getRepository(Employee::class)->find($id);
        if (null === $employee) {
            return null;
        }
        return $this->serializer->normalize($employee);
    }

    public function importEmployee(array $employees): bool
    {
        try {
            foreach ($employees as $employee) {
                $this->entityManager->persist($employee);
            }
            $this->entityManager->flush();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}