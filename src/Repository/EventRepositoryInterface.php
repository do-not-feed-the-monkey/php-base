<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;

interface EventRepositoryInterface
{
    /**
     * @return Event[]
     */
    public function getAll(): array;

    public function save(Event $event): void;

    public function getOldestUnqualifiedEvent(): ?Event;
}
