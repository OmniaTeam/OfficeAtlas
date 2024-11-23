<?php

namespace App\Service\Request;

use App\Entity\Request;
use Doctrine\ORM\EntityManagerInterface;

class RequestService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getAllRequests(): array
    {
        return $this->entityManager->getRepository(Request::class)->findAll();
    }

    public function create(): Request
    {
        $request = new Request();

    }
}