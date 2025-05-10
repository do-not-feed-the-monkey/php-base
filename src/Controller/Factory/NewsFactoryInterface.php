<?php

declare(strict_types=1);

namespace App\Controller\Factory;

use App\Entity\News;
use Symfony\Component\Uid\Uuid;

interface NewsFactoryInterface
{
    public function create(
        Uuid $id,
        string $content,
        ?string $title,
        ?\DateTimeImmutable $publishedAt,
        \DateTimeImmutable $createdAt,
    ): News;
}
