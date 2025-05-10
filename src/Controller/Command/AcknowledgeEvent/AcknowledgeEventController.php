<?php

declare(strict_types=1);

namespace App\Controller\Command\AcknowledgeEvent;

use App\Controller\Shared\ResponseFactory;
use App\Entity\Event;
use App\Repository\EventRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class AcknowledgeEventController extends AbstractController
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly ResponseFactory $responseFactory,
    ) {
    }

    #[Route('/api/events/{id}/ack', name: 'acknowledge_event', methods: ['PATCH'])]
    public function __invoke(Event $event): JsonResponse
    {
        $event->setAcknowledged(true);

        $this->eventRepository->save($event);

        return $this->responseFactory->accepted();
    }
}
