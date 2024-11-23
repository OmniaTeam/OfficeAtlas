<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorController extends AbstractController
{
    public function __invoke(\Throwable $exception): JsonResponse
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $this->json([
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ], $exception->getStatusCode());
        }
        if ($exception instanceof \Exception) {
            return $this->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
        return $this->json([
            'code' => 500,
            'message' => 'Unknown error'
        ], 500);
    }
}