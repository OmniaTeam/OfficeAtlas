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

    public function sendEmail(SendEmailDTO $data): bool
    {
        try {
            $payload = $this->serializer->serialize($data, 'json');
            $res = $this->client->post('send_request', [
                'body' => $payload,
            ]);
            if ($res->getStatusCode() !== 200) {
                return false;
            }
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getSpec(): string
    {
        $res = $this->client->get('spec');
        $response = json_decode($res->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
        return $response['spec_id'];
    }
}