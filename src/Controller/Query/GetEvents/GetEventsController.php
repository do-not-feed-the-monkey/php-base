<?php

declare(strict_types=1);

namespace App\Controller\Query\GetEvents;

use App\Controller\Shared\ResponseFactory;
use App\Entity\Event;
use App\Repository\EventRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetEventsController extends AbstractController
{
    public function __construct(
        private readonly ResponseFactory $responseFactory,
        private readonly EventRepositoryInterface $eventRepository,
        private readonly GetEventsResponseItemFactoryInterface $getEventsResponseItemFactory,
    ) {
    }

    #[Route(path: '/api/events', name: 'get_events', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $events = $this->eventRepository->getAll();

        $response = new GetEventsResponse(
            ...array_map(function (Event $event) {
                return $this->getEventsResponseItemFactory->create($event);
            }, $events)
        );

        return $this->responseFactory->ok($response);
    }
}
