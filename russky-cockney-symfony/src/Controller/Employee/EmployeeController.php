<?php

namespace App\Controller\Employee;

use App\Entity\Employee;
use App\Service\Employee\EmployeeService;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/employee')]
#[Tag('Сотрудники')]
class EmployeeController extends AbstractController
{
    public function __construct(
        private EmployeeService $employeeService,
        private SerializerInterface $serializer,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/', name: 'employee_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $filter = $request->query->all();
        $employees = $this->employeeService->getEmployeesByPagination($filter);
        return $this->json($employees);
    }

    #[Route('/{id}/show', name: 'employee_show', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $employee = $this->employeeService->getEmployeeById($id);
        if (!$employee) {
            return $this->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
        }
        return $this->json($employee);
    }

    #[Route('/import/', name: 'employee_import', methods: ['POST'])]
    public function import(Request $request): JsonResponse
    {
        $payload = $request->toArray();
        $users = [];
        foreach ($payload['users'] as $userPayload) {
            $users[] = $this->serializer->denormalize($userPayload, Employee::class);
        }
        $status = $this->employeeService->importEmployee($users);
        return $this->json(['success' => $status]);
    }

    #[Route('/free', name: 'employee_free', methods: ['GET'])]
    public function getFreeEmployees(Request $request): JsonResponse
    {
        $userId = $this->getUser()->getId();
        $employeeRepository = $this->entityManager->getRepository(Employee::class);
        $user = $employeeRepository->find($userId);
        if ($user === null) {
            return $this->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }
        $employees = $this->employeeService->getFreeEmployees($user->getOffice()->getId());
        return $this->json($employees, context: [
            AbstractNormalizer::ATTRIBUTES => [
                'id', 'fio'
            ]
        ]);
    }
}