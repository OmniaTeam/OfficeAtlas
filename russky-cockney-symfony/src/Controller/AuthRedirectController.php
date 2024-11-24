<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthRedirectController extends AbstractController
{
    #[Route('/api/auth/redirect', name: 'auth_redirect', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        return $this->redirect('https://theomnia.ru/', 307);
    }

}