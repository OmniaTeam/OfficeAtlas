<?php

namespace App\Controller\Workspace;

use App\Entity\Cabinet;
use App\Entity\Employee;
use App\Service\Workspace\WorkspaceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/workspaces')]
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
}