<?php

namespace App\Controller\Workspace;

use App\Entity\Cabinet;
use App\Entity\Employee;
use App\Service\Workspace\WorkspaceService;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/workspaces')]
#[Tag('Рабочие места')]
class WorkspaceController extends AbstractController
{
    public function __construct(
        private WorkspaceService $workspaceService,
    ) {
    }

    #[Route('/', name: 'workspace_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->workspaceService->getAllWorkspaces(),
            context: [
                AbstractNormalizer::CALLBACKS => [
                    'cabinet' => function ($object) {
                        return $object instanceof Cabinet ? [
                            'id' => $object->getId(),
                            'number' => $object->getNumber(),
                            'department' => $object->getDepartment(),
                        ] : null;
                    },
                    'employee' => function ($object) {
                        return $object instanceof Employee ? [
                            'id' => $object->getId(),
                            'fio' => $object->getFio(),
                        ] : null;
                    }
                ]
            ]
        );
    }

    #[Route('/{id}/add/employee', name: 'workspace_add_employee', methods: ['PUT'])]
    public function addEmployee(Request $request, int $id): JsonResponse
    {
        $employeeId = $request->toArray()['id'] ?? null;
        if ($employeeId === null) {
            return $this->json([
                'success' => false,
                'message' => 'Не передан id'
            ], 400);
        }
        $status = $this->workspaceService->addEmployee($id, $employeeId);
        if (!$status) {
            return $this->json([
                'success' => false,
                'message' => 'Error'
            ], 400);
        }
        return $this->json([
            'success' => true,
            'message' => 'Employee added'
        ], 201);
    }
}