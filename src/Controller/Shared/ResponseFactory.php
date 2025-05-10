<?php

declare(strict_types=1);

namespace App\Controller\Shared;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseFactory
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function ok(ResponseInterface $response): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($response, 'json'),
            json: true,
        );
    }
}
