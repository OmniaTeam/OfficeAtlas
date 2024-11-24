<?php

namespace App\Controller\Request;

use App\DTO\RequestCreateDTO;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Service\Employee\EmployeeService;
use App\Service\Request\RequestService;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/requests')]
class RequestController extends AbstractController
{
    public function __construct(
        private RequestService $requestService,
        private SerializerInterface $serializer,
        private EmployeeService $employeeService,
    ) {
    }

    #[Route('/', name: 'request_index', methods: ['GET'])]
    #[Tag('Заявки')]
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
                        ] : null;
                    }
                ],
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['maintenances'],
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object->getId();
                }
            ]
        );
    }

    #[Route('/create', name: 'request_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $reqDto = $this->serializer->deserialize($request->getContent(), RequestCreateDTO::class, 'json');
        $userId = $this->getUser()->getId();
        $user = $this->employeeService->getUserByiId($userId);
        if ($user === null) {
            return $this->json([
                'success' => false,
                'message' => 'Users not found'
            ], 403);
        }
        $request = $this->requestService->create($reqDto, $user);
        if ($request === null) {
            return $this->json([
                'success' => false,
                'message' => 'Requests created failed'
            ], 500);
        }
        return $this->json($request);
    }
}