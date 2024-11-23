<?php

namespace App\Service;

use App\Client\ExternalClient;

class SendEmailService
{
    public function __construct(
        private ExternalClient $client,
    ) {
    }

}