<?php

namespace App\Service\MapScheme;

use App\Repository\MapSchemeRepository;

class MapSchemeService
{
    public function __construct(
        private MapSchemeRepository $mapSchemeRepository,
    ) {
    }
}