<?php

namespace App\Repository;

use App\Entity\EventSentiment;

interface EventSentimentRepositoryInterface
{
    public function save(EventSentiment $event): void;
}
