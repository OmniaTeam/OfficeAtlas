<?php

namespace App\Controller\EquipmentCopy;

use App\Service\EquipmentCopy\EquipmentCopyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/equipments/')]
class EquipmentCopyController extends AbstractController
{
    public function __construct(
        private EquipmentCopyService $equipmentCopyService,
    ) {
    }

    #[Route('/', name: 'equipment_copy', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $perPage = $request->query->getInt('perPage', 10);
        return $this->json($this->equipmentCopyService->getEquipmentCopiesByPagination($page, $perPage));
    }

}