<?php

namespace App\Entity;

use App\Repository\EventSentimentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: EventSentimentRepository::class)]
class EventSentiment
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME, unique: true)]
        private Uuid $id,
        #[ORM\OneToOne(mappedBy: 'sentiment', cascade: ['persist', 'remove'])]
        private readonly Event $event,
        #[ORM\OneToOne(cascade: ['persist', 'remove'])]
        #[ORM\JoinColumn(nullable: false)]
        private SentimentDetails $agitation,
        #[ORM\OneToOne(cascade: ['persist', 'remove'])]
        #[ORM\JoinColumn(nullable: false)]
        private SentimentDetails $neutral,
        #[ORM\OneToOne(cascade: ['persist', 'remove'])]
        #[ORM\JoinColumn(nullable: false)]
        private SentimentDetails $positive,
    ) {
        $this->event->setSentiment($this);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getAgitation(): SentimentDetails
    {
        return $this->agitation;
    }

    public function getNeutral(): SentimentDetails
    {
        return $this->neutral;
    }

    public function getPositive(): SentimentDetails
    {
        return $this->positive;
    }
}
