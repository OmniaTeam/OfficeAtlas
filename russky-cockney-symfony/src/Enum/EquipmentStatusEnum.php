<?php

namespace App\Enum;

enum EquipmentStatusEnum
{
    case ACTIVE;
    case INACTIVE;
    case UNDER_MAINTENANCE;
    case IN_REPAIR;
    case DECOMMISSIONED;
    case AVAILABLE;
    case UNAVAILABLE;
    case IN_STORAGE;
    case OUT_OF_SERVICE;

    public function code(): string
    {
        return match ($this) {
            self::ACTIVE => 'ACTIVE',
            self::INACTIVE => 'INACTIVE',
            self::UNDER_MAINTENANCE => 'UNDER_MAINTENANCE',
            self::IN_REPAIR => 'IN_REPAIR',
            self::DECOMMISSIONED => 'DECOMMISSIONED',
            self::AVAILABLE => 'AVAILABLE',
            self::UNAVAILABLE => 'UNAVAILABLE',
            self::IN_STORAGE => 'IN_STORAGE',
            self::OUT_OF_SERVICE => 'OUT_OF_SERVICE',
        };
    }

    public function text(): string
    {
        return match ($this) {
            self::ACTIVE => 'Активное оборудование',
            self::INACTIVE => 'Неактивное оборудование',
            self::UNDER_MAINTENANCE => 'На обслуживании',
            self::IN_REPAIR => 'В ремонте',
            self::DECOMMISSIONED => 'Списанное оборудование',
            self::AVAILABLE => 'Доступно для использования',
            self::UNAVAILABLE => 'Недоступно для использования',
            self::IN_STORAGE => 'На складе',
            self::OUT_OF_SERVICE => 'Вне эксплуатации',
        };
    }

}
