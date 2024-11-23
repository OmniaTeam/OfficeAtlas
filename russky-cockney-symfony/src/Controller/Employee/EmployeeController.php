<?php

namespace App\Controller\Employee;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Service\Employee\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/employee')]
class EmployeeController extends AbstractController
{
    public function __construct(
        private EmployeeService $employeeService,
        private SerializerInterface $serializer,
    ) {
    }

    #[Route('/', name: 'employee_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $perPage = $request->query->getInt('perPage', 20);
        $employees = $this->employeeService->getEmployeesByPagination($page, $perPage);
        return $this->json(
            $employees
        );
    }

    #[Route('/show', name: 'employee_show', methods: ['GET'])]
    public function show(Request $request): JsonResponse
    {
        $id = $request->query->getInt('id');
        $employee = $this->employeeService->getEmployeeById($id);
        if (!$employee) {
            return $this->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
        }
        return $this->json($employee);
    }

    #[Route('/test')]
    public function test(EmployeeRepository $repository): JsonResponse
    {
        dd($repository->findAllSysAdminWithInProgressRequests());
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
}