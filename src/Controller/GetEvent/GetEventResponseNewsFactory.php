<?php

declare(strict_types=1);

namespace App\Controller\GetEvent;

use App\Entity\News;
use App\Shared\DateFormatter;

readonly class GetEventResponseNewsFactory implements GetEventResponseNewsFactoryInterface
{
    public function create(News $news): GetEventResponseNewsItem
    {
        return new GetEventResponseNewsItem(
            (string) $news->getId(),
            $news->getTitle(),
            $news->getContent(),
            DateFormatter::formatNullable($news->getPublishedAt()),
            DateFormatter::format($news->getCreatedAt()),
        );
    }
}
