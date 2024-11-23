<?php

namespace App\Service\Cabinet;

use App\Entity\Cabinet;
use Doctrine\ORM\EntityManagerInterface;

class CabinetService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getAllCabinets(): array
    {
        return $this->entityManager->getRepository(Cabinet::class)->findAll();
    }
}