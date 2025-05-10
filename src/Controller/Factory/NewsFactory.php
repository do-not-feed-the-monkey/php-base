<?php

declare(strict_types=1);

namespace App\Controller\Factory;

use App\Entity\News;
use App\Shared\UuidGeneratorInterface;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

readonly class NewsFactory implements NewsFactoryInterface
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
    ) {
    }

    public function create(
        Uuid $id,
        string $content,
        ?string $title,
        ?DateTimeImmutable $publishedAt,
        DateTimeImmutable $createdAt
    ): News {
        return new News(
            $this->uuidGenerator->generate(),
            $content,
            $title,
            $publishedAt,
            $createdAt,
        );
    }
}
