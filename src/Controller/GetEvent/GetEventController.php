<?php

declare(strict_types=1);

namespace App\Controller\GetEvent;

use App\Controller\Shared\ResponseFactory;
use App\Entity\Event;
use App\Repository\EventRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetEventController extends AbstractController
{
    public function __construct(
        private readonly ResponseFactory $responseFactory,
        private readonly GetEventResponseFactoryInterface $getEventsResponseItemFactory,
    ) {
    }

    #[Route(path: '/api/events/{id}', name: 'get_event', methods: ['GET'])]
    public function __invoke(Event $event): JsonResponse
    {
        $response = $this->getEventsResponseItemFactory->create($event);

        return $this->responseFactory->ok($response);
    }
}
