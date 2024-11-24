<?php

namespace App\Service\EquipmentCopy;

use App\Entity\Employee;
use App\Entity\EquipmentCopy;
use App\Entity\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class EquipmentCopyService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    ) {
    }

    public function getEquipmentCopiesByPagination(int $page, int $perPage): array
    {
        $repository = $this->entityManager->getRepository(EquipmentCopy::class);
        $total = $repository->count([]);
        if ($page < 1) {
            $page = 1;
        }
        $pagination = [
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page,
        ];
        $equipmentCopies = $repository->findBy([], limit: $perPage, offset:($page - 1) * $perPage);
        $equipmentCopiesArr = $this->serializer->normalize($equipmentCopies, context: [
            AbstractNormalizer::CALLBACKS => [
                'employee' => function ($employee) {
                    return $employee instanceof Employee ? [
                        'id' => $employee->getId(),
                        'fio' => $employee->getFio(),
                    ] : null;
                },
                'requests' => function ($requests) {
                    $result = [];
                    foreach ($requests as $request) {
                        $result[] = $request instanceof Request ? [
                            'id' => $request->getId(),
                            'type' => $request->getType(),
                            'status' => $request->getStatus(),
                        ] : null;
                    }
                    return $result;
                }
            ]
        ]);
        return [
            'pagination' => $pagination,
            'data' => $equipmentCopiesArr
        ];
    }

    public function createEquipmentCopy(EquipmentCopy $equipmentCopy): bool
    {
        try {
            $this->entityManager->persist($equipmentCopy);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}