<?php

namespace App\Controller\MapScheme;

use App\Entity\Cabinet;
use App\Entity\Workspace;
use App\Repository\MapSchemeRepository;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/map-scheme')]
#[Tag('Схема')]
class MapSchemeController extends AbstractController
{
    public function __construct(
        private readonly MapSchemeRepository $mapSchemeRepository
    ) {
    }

    #[Route('/{id}/plans', name: 'map_scheme_plans', methods: ['GET'])]
    public function getPlans(int $id): JsonResponse
    {
        $mapScheme = $this->mapSchemeRepository->find($id);
        if (null === $mapScheme) {
            return $this->json([
                'success' => false,
                'message' => 'Map scheme not found',
            ], 404);
        }
        return $this->json($mapScheme->getPlans(), context: [
            AbstractNormalizer::CALLBACKS => [
                'workspace' => function ($object) {
                    return $object instanceof Workspace ? [
                        'id' => $object->getId(),
                        'cabinet' => $object->getCabinet()->getNumber(),
                        'name' => $object->getName(),
                        'status' => $object->getStatus(),
                    ] : null;
                },
                'cabinet' => function ($object) {
                    return $object instanceof Cabinet ? [
                        'id' => $object->getId(),
                        'number' => $object->getNumber(),
                        'department' => $object->getDepartment(),
                    ] : null;
                }
            ],
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['mapScheme']
        ]);
    }
}