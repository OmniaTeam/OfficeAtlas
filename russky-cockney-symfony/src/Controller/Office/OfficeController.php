<?php

namespace App\Controller\Office;

use App\Entity\Cabinet;
use App\Entity\Employee;
use App\Entity\Office;
use App\Service\Employee\EmployeeService;
use App\Service\Office\OfficeService;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/offices')]
#[Tag('Офисы')]
class OfficeController extends AbstractController
{
    public function __construct(
        private OfficeService $officeService,
        private EmployeeService $employeeService,
        private SerializerInterface $serializer
    ) {
    }

    #[Route('/', name: 'office_index', methods: ['GET'])]
    public function index(): JsonResponse {
        return $this->json(
            $this->officeService->getAllOffices(),
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['employees', 'mapSchemes']
            ]
        );
    }

    #[Route('/create', name: 'office_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $office = $this->serializer->deserialize($request->getContent(), Office::class, 'json');
        $result = $this->officeService->create($office);
        if (!$result) {
            return $this->json([
                'success' => false,
                'message' => 'Office could not be created.',
            ], 400);
        }
        return $this->json([
            'success' => true,
            'message' => 'Office created.',
        ], 201);
    }

    #[Route('/{id}/map-schemes', name: 'office_map_schemes', methods: ['GET'])]
    public function getMapSchemes(int $id): JsonResponse
    {
        $result = $this->officeService->getMapSchemesById($id);
        if (!$result) {
            return $this->json([
                'success' => false,
                'message' => 'Map schemes could not be found.',
            ], 404);
        }
        return $this->json($result, context: [
            AbstractNormalizer::IGNORED_ATTRIBUTES  => ['office', 'plans']
        ]);
    }

    #[Route('/{id}/employee/import', name: 'office_employee_import', methods: ['POST'])]
    public function importEmployees(Request $request, int $id): JsonResponse
    {
        $payload = $request->toArray();
        $office = $this->officeService->getById($id);
        if (null === $office) {
            return $this->json([
                'success' => false,
                'message' => 'Office not found'
            ], 404);
        }
        $users = [];
        foreach ($payload['users'] as $userPayload) {
            $user = $this->serializer->denormalize($userPayload, Employee::class);
            $user->setOffice($office);
            $users[] = $user;
        }
        $status = $this->employeeService->importEmployee($users);
        return $this->json(['success' => $status]);
    }
}