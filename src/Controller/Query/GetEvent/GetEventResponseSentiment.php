<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvent;

final readonly class GetEventResponseSentiment
{
    public function __construct(
        public GetEventResponseSentimentItem $agitation,
        public GetEventResponseSentimentItem $neutral,
        public GetEventResponseSentimentItem $positive,
    ) {
    }
}
