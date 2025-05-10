<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvents;

use App\Entity\Event;

interface GetEventsResponseItemFactoryInterface
{
    public function create(Event $event): GetEventsResponseItem;
}
