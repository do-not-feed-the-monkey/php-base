<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Enum\EventWeight;
use App\Entity\EventSentiment;
use App\Repository\NewsRepositoryInterface;

readonly class WeightCalculator implements WeightCalculatorInterface
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function calculate(int $newsNumber, ?EventSentiment $eventSentiment): EventWeight
    {
        if ($eventSentiment === null) {
            return EventWeight::WEIGHT_0;
        }

        $calculatedWeight = $this->calculateEventWeight(
            $this->newsRepository->getAverageNumberOfNewsPerEvent(),
            $newsNumber,
            $eventSentiment->getAgitation()->getStrength(),
            $eventSentiment->getNeutral()->getStrength(),
            $eventSentiment->getPositive()->getStrength(),
        );

        return EventWeight::from($calculatedWeight);
    }

    function calculateEventWeight(int $averageNewsCount, int $newsCount, int $agitationStrength, int $neutralStrength, int $positiveStrength): int {
        if ($averageNewsCount <= 0 || $newsCount <= 0) return 1;

        // Step 1: Normalize news count (0–1 range, capped at 2x average)
        $newsRatio = min(1.0, $newsCount / ($averageNewsCount * 2));

        // Step 2: Total sentiment strength
        $totalStrength = $agitationStrength + $neutralStrength + $positiveStrength;
        if ($totalStrength == 0) return 1;

        // Step 3: Compute sentiment ratios
        $agitationRatio = $agitationStrength / $totalStrength;
        $neutralRatio   = $neutralStrength / $totalStrength;
        $positiveRatio  = $positiveStrength / $totalStrength;

        // Step 4: Sentiment score favors agitation
        // Agitation weighted more heavily, neutral mildly penalizes, positive penalizes more
        $sentimentScore = ($agitationRatio * 1.5) - ($neutralRatio * 0.3) - ($positiveRatio * 0.6);

        // Step 5: Combine with news ratio
        $rawScore = $newsRatio * max(0.0, $sentimentScore) * 10;

        // Step 6: Clamp to 1–10
        return (int) max(1, min(10, round($rawScore)));
    }
}
