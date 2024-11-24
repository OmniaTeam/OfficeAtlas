<?php

namespace App\Service;

use App\Client\ExternalClient;
use App\DTO\SendEmailDTO;
use App\Entity\Employee;
use App\Entity\Request;

class SendEmailService
{
    public function __construct(
        private ExternalClient $client,
    ) {
    }

    private function generateSendEmailDto(Employee $admin,Employee $employee, Request $request): SendEmailDto
    {
        $workspace = $employee->getWorkspaces()->current();
        $cabinet = $workspace->getCabinet();
        $sendEmailDto = new SendEmailDTO();
        $sendEmailDto->typeRequest = $request->getType();
        $sendEmailDto->statusRequest = $request->getStatus();
        $sendEmailDto->idRequest = $request->getId();
        $sendEmailDto->descriptionRequest = $request->getDescription();
        $sendEmailDto->fioEmployee = $employee->getFio();
        $sendEmailDto->emailEmployee = $employee->getEmail();
        $sendEmailDto->linkEmployee = $employee->getLink();
        $sendEmailDto->phoneEmployee = $employee->getPhone();
        $sendEmailDto->nameWorkspace = $workspace->getName();
        $sendEmailDto->numberCabinet = $cabinet->getNumber();
        $sendEmailDto->numberWorkspace = $workspace->getId();
        $sendEmailDto->departmentCabinet = $cabinet->getDepartment();
        $sendEmailDto->nameOffice = $employee->getOffice()->getName();
        $sendEmailDto->emailAdmin = $admin->getEmail();
        return $sendEmailDto;
    }

    public function send(Employee $admin, Employee $employee, Request $request): bool
    {
        $payloadData = $this->generateSendEmailDto($admin, $employee, $request);
        return $this->client->sendEmail($payloadData);
    }
}