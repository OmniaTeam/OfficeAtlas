<?php

namespace App\Controller\Cabinet;

use App\Entity\Office;
use App\Service\Cabinet\CabinetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/cabinets')]
class CabinetController extends AbstractController
{
    public function __construct(
        private CabinetService $cabinetService,
    ) {
    }

    #[Route('/', name: 'cabinet_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->cabinetService->getAllCabinets(),
            context: [
                AbstractNormalizer::CALLBACKS => [
                    'office' => function ($object) {
                        return $object instanceof Office ? [
                            'id' => $object->getId(),
                            'name' => $object->getName(),
                        ] : null;
                    },
                    'workspaces' => function ($object) {
                        $workspaces = [];
                        foreach ($object as $workspace) {
                            $workspaces[] = [
                                'id' => $workspace->getId(),
                                'name' => $workspace->getName(),
                            ];
                        }
                        return $workspaces;
                    }
                ]
            ]
        );
    }
}