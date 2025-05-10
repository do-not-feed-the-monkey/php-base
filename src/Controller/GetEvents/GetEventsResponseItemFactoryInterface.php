<?php

declare(strict_types=1);

namespace App\Controller\GetEvents;

use App\Entity\Event;

interface GetEventsResponseItemFactoryInterface
{
    public function create(Event $event): GetEventsResponseItem;
}
