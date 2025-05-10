<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvent;

use App\Entity\EventSentiment;

class GetEventResponseSentimentFactory implements GetEventResponseSentimentFactoryInterface
{
    public function create(?EventSentiment $sentiment): ?GetEventResponseSentiment
    {
        if ($sentiment === null) {
            return null;
        }

        return new GetEventResponseSentiment(
            new GetEventResponseSentimentItem(
                $sentiment->getAgitation()->getStrength(),
                $sentiment->getAgitation()->getDetectedEmotions()
            ),
            new GetEventResponseSentimentItem(
                $sentiment->getNeutral()->getStrength(),
                $sentiment->getNeutral()->getDetectedEmotions()
            ),
            new GetEventResponseSentimentItem(
                $sentiment->getPositive()->getStrength(),
                $sentiment->getPositive()->getDetectedEmotions()
            )
        );
    }
}
