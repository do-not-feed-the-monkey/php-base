<?php

declare(strict_types=1);

namespace App\Controller\GetEvents;


use App\Controller\Shared\ResponseInterface;

final readonly class GetEventsResponse implements ResponseInterface
{
    private array $items;

    public function __construct(
        GetEventsResponseItem ...$items
    ) {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
