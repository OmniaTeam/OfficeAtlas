<?php

namespace App\Service\Request;

use App\Client\ExternalClient;
use App\DTO\RequestCreateDTO;
use App\Entity\Employee;
use App\Entity\Request;
use App\Enum\RequestStatusEnum;
use App\Enum\RequestTypeEnum;
use App\Repository\EmployeeRepository;
use App\Repository\EquipmentCopyRepository;
use App\Service\SendEmailService;
use Doctrine\ORM\EntityManagerInterface;

class RequestService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ExternalClient $externalClient,
        private EmployeeRepository $employeeRepository,
        private EquipmentCopyRepository $equipmentCopyRepository,
        private SendEmailService $sendEmailService,
    ) {
    }

    public function getAllRequests(): array
    {
        return $this->entityManager->getRepository(Request::class)->findAll();
    }

    public function create(RequestCreateDTO $requestData, Employee $employee): ?Request
    {
        try {
            $request = new Request();
            $request->setEmployee($employee)
                ->setType($requestData->type)
                ->setDescription($requestData->description);
            $specialistId = $this->externalClient->getSpec();
            $specialist = $this->employeeRepository->find($specialistId);
            $request->setSpecialist($specialist);
            $request->setStatus(RequestStatusEnum::IN_PROGRESS->code());
            if ($requestData->type === RequestTypeEnum::REPAIR->code()) {
                $request->setEquipmentCopy(
                    $this->equipmentCopyRepository->find($requestData->equipmentId)
                );
            }
            $request->setDateStart(new \DateTimeImmutable());
            $request->setDateEnd(null);
            $this->entityManager->persist($request);
            $this->entityManager->flush();
            $this->sendEmailService->send($specialist, $employee, $request);
            return $request;
        } catch (\Exception $exception) {
            return null;
        }
    }
}