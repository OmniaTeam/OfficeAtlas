<?php

namespace App\Enum;

enum EquipmentQualityEnum
{
    case EXCELLENT;
    case GOOD;
    case FAIR;
    case POOR;
    case NEEDS_REPAIR;
    case OUT_OF_SERVICE;
    case OBSOLETE;

    public function code(): string
    {
        return match ($this) {
            self::EXCELLENT => 'EXCELLENT',
            self::GOOD => 'GOOD',
            self::FAIR => 'FAIR',
            self::POOR => 'POOR',
            self::NEEDS_REPAIR => 'NEEDS_REPAIR',
            self::OUT_OF_SERVICE => 'OUT_OF_SERVICE',
            self::OBSOLETE => 'OBSOLETE',
        };
    }

    public function text(): string
    {
        return match ($this) {
            self::EXCELLENT => 'Отличное состояние',
            self::GOOD => 'Хорошее состояние',
            self::FAIR => 'Удовлетворительное состояние',
            self::POOR => 'Плохое состояние',
            self::NEEDS_REPAIR => 'Требует ремонта',
            self::OUT_OF_SERVICE => 'Неисправно',
            self::OBSOLETE => 'Устаревшее',
        };
    }
}
