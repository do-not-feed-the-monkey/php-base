<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Enum\EventWeight;
use App\Entity\EventSentiment;

interface WeightCalculatorInterface
{
    public function calculate(int $newsNumber, ?EventSentiment $eventSentiment): EventWeight;
}
