<?php

namespace App\Service\Office;

use App\Entity\Office;
use Doctrine\ORM\EntityManagerInterface;

class OfficeService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getAllOffices(): array
    {
        $officeRepository = $this->entityManager->getRepository(Office::class);
        return $officeRepository->findAll();
    }

    public function getById(int $id): ?Office
    {
        $officeRepository = $this->entityManager->getRepository(Office::class);
        $office = $officeRepository->find($id);
        if (null === $office) {
            return null;
        }
        return $office;
    }

    public function getMapSchemesById(int $id): ?array
    {
        $officeRepository = $this->entityManager->getRepository(Office::class);
        $office = $officeRepository->find($id);
        if (null === $office) {
            return null;
        }
        return $office->getMapSchemes()->toArray();
    }

    public function create(Office $office): bool
    {
        try {
            $this->entityManager->persist($office);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}