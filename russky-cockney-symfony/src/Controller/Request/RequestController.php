<?php

namespace App\Controller\Request;

use App\Entity\Employee;
use App\Service\Request\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/requests')]
class RequestController extends AbstractController
{
    public function __construct(
        private RequestService $requestService
    ) {
    }

    #[Route('/', name: 'request_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->requestService->getAllRequests(),
            context: [
                AbstractNormalizer::CALLBACKS => [
                    'employee' => function ($attributeValue) {
                        return $attributeValue instanceof Employee ? [
                            'id' => $attributeValue->getId(),
                            'fio' => $attributeValue->getFio(),
                        ] : '';
                    }
                ],
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['maintenances'],
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object->getId();
                }
            ]
        );
    }
}