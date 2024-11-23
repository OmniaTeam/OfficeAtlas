<?php

namespace App\Service\Office;

use App\DTO\Request\PaginationRequest;
use App\Entity\Office;
use App\Repository\OfficeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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