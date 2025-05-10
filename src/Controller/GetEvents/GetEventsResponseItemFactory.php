<?php

declare(strict_types=1);

namespace App\Controller\GetEvents;

use App\Entity\Event;
use App\Repository\NewsRepositoryInterface;
use App\Shared\DateFormatter;

readonly class GetEventsResponseItemFactory implements GetEventsResponseItemFactoryInterface
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function create(Event $event): GetEventsResponseItem
    {
        return new GetEventsResponseItem(
            (string) $event->getId(),
            $event->getTitle(),
            $event->getDescription(),
            $event->getWeight()->value,
            $event->getSentiment()->value,
            DateFormatter::formatNullable($event->getStartedAt()),
            DateFormatter::format($event->getCreatedAt()),
            $this->newsRepository->countByEvent($event),
        );
    }
}
