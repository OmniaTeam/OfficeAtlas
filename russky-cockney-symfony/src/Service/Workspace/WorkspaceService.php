<?php

namespace App\Service\Workspace;

use App\Entity\Workspace;
use Doctrine\ORM\EntityManagerInterface;

class WorkspaceService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getAllWorkspaces(): array
    {
        return $this->entityManager->getRepository(Workspace::class)->findAll();
    }
}