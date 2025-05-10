<?php

declare(strict_types=1);

namespace App\Controller\GetEvent;


use App\Controller\Shared\ResponseInterface;

final readonly class GetEventResponse implements ResponseInterface
{

    private array $news;

    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public int $weight,
        public int $sentiment,
        public ?string $startedAt,
        public string $createdAt,
        array $news,
    ) {
        $this->news = $news;
    }

    public function getNews(): array
    {
        return $this->news;
    }
}
