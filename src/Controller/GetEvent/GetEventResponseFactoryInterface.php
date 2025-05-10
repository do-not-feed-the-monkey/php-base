<?php

declare(strict_types=1);

namespace App\Controller\GetEvent;

use App\Entity\Event;

interface GetEventResponseFactoryInterface
{
    public function create(Event $event): GetEventResponse;
}
