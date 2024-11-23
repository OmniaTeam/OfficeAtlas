<?php

namespace App\Enum;

enum RequestTypeEnum
{
    case SOFT_UPDATE;
    case REPAIR;
    case REPLACEMENT;
    case ISSUE_EQUIPMENT;

    public function code(): string
    {
        return match ($this) {
            self::SOFT_UPDATE => 'SOFT_UPDATE',
            self::REPAIR => 'REPAIR',
            self::REPLACEMENT => 'REPLACEMENT',
            self::ISSUE_EQUIPMENT => 'ISSUE_EQUIPMENT',
        };
    }

    public function text(): string
    {
        return match ($this) {
            self::SOFT_UPDATE => 'Обновление программного обеспечения',
            self::REPAIR => 'Починка оборудования',
            self::REPLACEMENT => 'Переезд сотрудника на другое рабочее место',
            self::ISSUE_EQUIPMENT => 'Выдача оборудования',
        };
    }

}
