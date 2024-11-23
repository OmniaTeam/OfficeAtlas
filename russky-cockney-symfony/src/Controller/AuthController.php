<?php

namespace App\Controller;


use App\Entity\Employee;
use App\Entity\Office;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class AuthController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/api/user/current', name: 'user_current', methods: ['GET'])]
    public function getCurrentUser(Request $request): JsonResponse
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
        return $this->json($user,
            context: [
                AbstractNormalizer::CALLBACKS => [
                    'office' => function ($office) {
                        return $office instanceof Office ? [
                            'id' => $office->getId(),
                            'name' => $office->getName(),
                        ] : null;
                    }
                ],
                AbstractNormalizer::IGNORED_ATTRIBUTES => [
                    'workspaces',
                    'requests',
                    'claim',
                ]
            ]);
    }
}