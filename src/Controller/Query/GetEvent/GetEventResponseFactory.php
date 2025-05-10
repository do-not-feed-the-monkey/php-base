<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvent;

use App\Entity\Event;
use App\Entity\News;
use App\Shared\DateFormatter;

readonly class GetEventResponseFactory implements GetEventResponseFactoryInterface
{
    public function __construct(
        private GetEventResponseNewsFactoryInterface $getEventResponseNewsFactory,
        private GetEventResponseSentimentFactoryInterface $eventResponseSentimentFactory,
    ) {
    }

    public function create(Event $event): GetEventResponse
    {
        $news = array_map(
            function (News $news): GetEventResponseNewsItem {
                return $this->getEventResponseNewsFactory->create($news);
            }, $event->getNews()->toArray(),
        );

        return new GetEventResponse(
            (string)$event->getId(),
            $event->getTitle(),
            $event->getDescription(),
            $event->getWeight()->value,
            DateFormatter::formatNullable($event->getStartedAt()),
            DateFormatter::format($event->getCreatedAt()),
            $this->eventResponseSentimentFactory->create($event->getSentiment()),
            $news,
        );
    }
}
