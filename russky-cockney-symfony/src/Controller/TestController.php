<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\ExternalClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    public function __construct(
        private ExternalClient $externalClient,
    ) {
    }

    #[Route('/api/test/', name: 'test', methods: ['GET'])]
    public function index(Request $request): Response
    {
        dd($this->externalClient->getSpec());
        return $this->json([]);
    }
}
