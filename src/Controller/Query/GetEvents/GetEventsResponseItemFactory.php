<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvents;

use App\Entity\Event;
use App\Repository\NewsRepositoryInterface;
use App\Service\WeightCalculatorInterface;
use App\Shared\DateFormatter;

readonly class GetEventsResponseItemFactory implements GetEventsResponseItemFactoryInterface
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
        private WeightCalculatorInterface $weightCalculator,

    ) {
    }

    public function create(Event $event): GetEventsResponseItem
    {
        return new GetEventsResponseItem(
            (string) $event->getId(),
            $event->getTitle(),
            $event->getDescription(),
            $this->weightCalculator->calculate(
                $event->getNews()->count(),
                $event->getSentiment(),
            )->value,
            DateFormatter::formatNullable($event->getStartedAt()),
            DateFormatter::format($event->getCreatedAt()),
            $this->newsRepository->countByEvent($event),
        );
    }
}
