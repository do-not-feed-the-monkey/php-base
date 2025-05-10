<?php

declare(strict_types=1);

namespace App\Controller\GetEvent;

final readonly class GetEventResponseNewsItem
{
    public function __construct(
        public string $id,
        public ?string $title,
        public string $content,
        public ?string $publishedAt,
        public string $createdAt,
    ) {
    }
}
