<?php

namespace App\DTO;

class RequestCreateDTO
{
    public string $type;
    public string $description;
    public ?int $equipmentId = null;
}
