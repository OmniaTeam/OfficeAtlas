<?php

namespace App\Service\Workspace;

use App\Entity\Employee;
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

    public function addEmployee(int $workspaceId, string $employeeId): bool
    {
        try {
            $workspace = $this->entityManager->getRepository(Workspace::class)->find($workspaceId);
            if ($workspace === null) {
                return false;
            }
            $employee = $this->entityManager->getRepository(Employee::class)->find($employeeId);
            if ($employee === null) {
                return false;
            }
            $workspace->setEmployee($employee);
            $workspace->setStatus('PASS');
            $this->entityManager->persist($workspace);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}