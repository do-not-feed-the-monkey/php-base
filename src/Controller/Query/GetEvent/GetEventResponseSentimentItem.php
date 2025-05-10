<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvent;


use App\Controller\Shared\ResponseInterface;

final readonly class GetEventResponseSentimentItem
{
    /**
     * @param int $strength
     * @param string[] $emotionsDetected
     */
    public function __construct(
        public int $strength,
        public array $emotionsDetected,
    ) {
    }
}
