<?php

namespace App\Enum;

enum EmployeeFilterFieldsEnum
{
    case FIO;
    case SPECIALIZATION;
    case DEPARTMENT;
    case PHONE;
    case LINK;
    case EMAIL;
    case ROLE;

    public function param(): string
    {
        return match ($this) {
            self::FIO => 'fio',
            self::SPECIALIZATION => 'specialization',
            self::DEPARTMENT => 'department',
            self::PHONE => 'phone',
            self::LINK => 'link',
            self::EMAIL => 'email',
            self::ROLE => 'role',
        };
    }
}
