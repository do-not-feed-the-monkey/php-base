<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use App\Entity\News;

interface NewsRepositoryInterface
{
    public function countByEvent(Event $event): int;

    public function save(News $news): void;
}
