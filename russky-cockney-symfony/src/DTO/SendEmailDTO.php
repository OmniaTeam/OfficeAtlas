<?php

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\SerializedName;

class SendEmailDTO
{
    #[SerializedName('id_request')]
    public int $idRequest;

    #[SerializedName('type_request')]
    public int $typeRequest;

    #[SerializedName('status_request')]
    public string $statusRequest;

    #[SerializedName('description_request')]
    public string $descriptionRequest;

    #[SerializedName('fio_employee')]
    public string $fioEmployee;

    #[SerializedName('phone_employee')]
    public string $phoneEmployee;

    #[SerializedName('email_employee')]
    public string $emailEmployee;

    #[SerializedName('link_employee')]
    public string $linkEmployee;

    #[SerializedName('name_workspace')]
    public string $nameWorkspace;

    #[SerializedName('number_cabinet')]
    public int $numberCabinet;

    #[SerializedName('number_workspace')]
    public int $numberWorkspace;

    #[SerializedName('department_cabinet')]
    public string $departmentCabinet;

    #[SerializedName('name_office')]
    public string $nameOffice;

    #[SerializedName('email_admin')]
    public string $emailAdmin;
}