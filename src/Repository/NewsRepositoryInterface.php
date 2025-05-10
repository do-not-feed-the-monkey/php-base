<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;

interface NewsRepositoryInterface
{
    public function countByEvent(Event $event): int;
}
