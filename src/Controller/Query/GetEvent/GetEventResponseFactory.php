<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvent;

use App\Entity\Event;
use App\Entity\News;
use App\Service\WeightCalculatorInterface;
use App\Shared\DateFormatter;

readonly class GetEventResponseFactory implements GetEventResponseFactoryInterface
{
    public function __construct(
        private GetEventResponseNewsFactoryInterface $getEventResponseNewsFactory,
        private GetEventResponseSentimentFactoryInterface $eventResponseSentimentFactory,
        private WeightCalculatorInterface $weightCalculator,
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
            $this->weightCalculator->calculate(
                $event->getNews()->count(),
                $event->getSentiment(),
            )->value,
            DateFormatter::formatNullable($event->getStartedAt()),
            DateFormatter::format($event->getCreatedAt()),
            $this->eventResponseSentimentFactory->create($event->getSentiment()),
            $event->getExpertComment(),
            $event->getOfficialAnnouncement(),
            $news,
        );
    }
}
