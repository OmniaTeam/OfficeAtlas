<?php

namespace App\Enum;

enum PaginationFieldsEnum
{
    case CURRENT_PAGE;
    case PER_PAGE;

    public function param(): string
    {
        return match ($this) {
            self::CURRENT_PAGE => 'currentPage',
            self::PER_PAGE => 'perPage',
        };
    }
}
