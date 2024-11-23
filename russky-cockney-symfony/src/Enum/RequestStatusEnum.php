<?php

namespace App\Enum;

use App\Entity\Request;

enum RequestStatusEnum
{
    case IN_PROGRESS;
    case COMPLETED;

    public function code(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'IN_PROGRESS',
            self::COMPLETED => 'COMPLETED',
        };
    }

    public function text(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'В работе',
            self::COMPLETED => 'Завершена',
        };
    }

}
