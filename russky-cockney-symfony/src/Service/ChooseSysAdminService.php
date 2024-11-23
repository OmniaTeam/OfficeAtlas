<?php

namespace App\Service;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;

class ChooseSysAdminService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    private function getAllSysAdmins(): array
    {
        $repository = $this->entityManager->getRepository(Employee::class);

        return $repository->findBy(
            [
                'role' => 'ROLE_SYSTEM_ADMINISTRATOR'
            ]
        );
    }

}