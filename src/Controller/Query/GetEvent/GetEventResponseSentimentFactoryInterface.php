<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvent;

use App\Entity\EventSentiment;

interface GetEventResponseSentimentFactoryInterface
{
    public function create(?EventSentiment $sentiment): ?GetEventResponseSentiment;
}
