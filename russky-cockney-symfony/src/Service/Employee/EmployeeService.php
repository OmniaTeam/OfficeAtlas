<?php

namespace App\Service\Employee;

use App\Entity\Employee;
use App\Entity\EquipmentCopy;
use App\Entity\Office;
use App\Entity\Request;
use App\Entity\Workspace;
use App\Enum\PaginationFieldsEnum;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class EmployeeService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EmployeeRepository $employeeRepository,
        private SerializerInterface $serializer,
    ) {
    }

    public function getAllEmployees(): array
    {
        return $this->entityManager->getRepository(Employee::class)->findAll();
    }

    public function getFreeEmployees(int $officeId): array
    {
        return $this->employeeRepository->findFreeEmployees($officeId);
    }

    public function getEmployeesByPagination(array $filter):?array
    {
        $total = $this->employeeRepository->count([]);
        $employees = $this->employeeRepository->findEmployeeByFilter($filter);
        $pagination = [
            'total' => $total,
            PaginationFieldsEnum::PER_PAGE->param() => $filter[PaginationFieldsEnum::PER_PAGE->param()],
            PaginationFieldsEnum::CURRENT_PAGE->param() => $filter[PaginationFieldsEnum::CURRENT_PAGE->param()],
        ];
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

    public function getUserByiId(string $id): ?Employee
    {
        $user = $this->employeeRepository->find($id);
        if (!$user) {
            return null;
        }
        return $user;
    }

    public function getEmployeeById(string $id): ?array
    {
        $employee = $this->entityManager->getRepository(Employee::class)->find($id);
        if (null === $employee) {
            return null;
        }
        return $this->serializer->normalize($employee, context: [
            AbstractNormalizer::CALLBACKS => [
                'office' => function ($office) {
                    return $office instanceof Office ? [
                        'id' => $office->getId(),
                        'name' => $office->getName(),
                        'address' => $office->getAddress(),
                    ] : null;
                },
                'workspaces' => function ($workspaces) {
                    $result = [];
                    foreach ($workspaces as $workspace) {
                        $result[] = $workspace instanceof Workspace ? [
                            'id' => $workspace->getId(),
                            'name' => $workspace->getName(),
                            'cabinetNumber' => $workspace->getCabinet()->getNumber(),
                        ] : null;
                    }
                    return $result;
                },
                'requests' => function ($requests) {
                    $result = [];
                    foreach ($requests as $request) {
                        $result[] = $request instanceof Request ? [
                            'id' => $request->getId(),
                            'type' => $request->getType(),
                            'status' => $request->getStatus(),
                            'description' => $request->getDescription(),
                        ] : null;
                    }
                    return $result;
                },
                'claim' => function ($claim) {
                    $result = [];
                    foreach ($claim as $request) {
                        $result[] = $request instanceof Request ? [
                            'id' => $request->getId(),
                            'type' => $request->getType(),
                            'status' => $request->getStatus(),
                            'description' => $request->getDescription(),
                        ] : null;
                    }
                    return $result;
                },
                'equipmentCopies' => function ($equipmentCopies) {
                    $result = [];
                    foreach ($equipmentCopies as $equipment) {
                        $result[] = $equipment instanceof EquipmentCopy ? [
                            'id' => $equipment->getId(),
                            'serialnum' => $equipment->getSerialnum(),
                            'status' => $equipment->getStatus(),
                            'name' => $equipment->getName(),
                            'model' => $equipment->getModel(),
                            'type' => $equipment->getType(),
                        ] : null;
                    }
                    return $result;
                }
            ]
        ]);
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