<?php

namespace App\DTO;

class SendEmailDTO
{
    public int $idRequest;
    public int $typeRequest;
    public string $statusRequest;
    public string $descriptionRequest;
    public string $fioEmployee;
    public string $phoneEmployee;
    public string $emailEmployee;
    public string $linkEmployee;
    public string $nameWorkspace;
    public int $numberCabinet;
    public string $departmentCabinet;
    public string $nameOffice;
}