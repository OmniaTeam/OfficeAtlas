<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/api/test/', name: 'test', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        return $this->json(['message' => $user->getName()]);
    }
}
