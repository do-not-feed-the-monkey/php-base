<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvents;

final readonly class GetEventsResponseItem
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public int $weight,
        public ?string $startedAt,
        public string $createdAt,
        public int $newsCount,
    ) {
    }
}
