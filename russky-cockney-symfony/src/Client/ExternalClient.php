<?php

namespace App\Client;

use App\DTO\SendEmailDTO;
use GuzzleHttp\Client;
use Symfony\Component\Serializer\SerializerInterface;

class ExternalClient
{
    private Client $client;
    public function __construct(
        private SerializerInterface $serializer,
        private string $baseUrl,
    ) {
        $this->client = new Client(['base_uri' => $this->baseUrl]);
    }

    public function sendEmail(SendEmailDTO $data): array
    {
        $payload = $this->serializer->serialize($data, 'json');
        #TODO Узнать и заполнить
        $res = $this->client->post('/', [
            'body' => $payload,
        ]);
        return $this->serializer->deserialize($res->getBody()->getContents(), 'array', 'json');
    }

}