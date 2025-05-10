<?php

namespace App\Entity;

use App\Entity\Enum\EventSentiment;
use App\Entity\Enum\EventWeight;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME, unique: true)]
        private readonly Uuid $id,
        #[ORM\Column(type: Types::TEXT)]
        private string $title,
        #[ORM\Column(type: Types::TEXT)]
        private string $description,
        #[ORM\ManyToMany(targetEntity: News::class, inversedBy: 'events', cascade: ['persist', 'remove'])]
        private Collection $news,
        /**
         * @var Collection<int, News>
         */
        #[ORM\Column(type: Types::INTEGER, enumType: EventWeight::class)]
        private EventWeight $weight = EventWeight::WEIGHT_0,
        #[ORM\Column(type: Types::INTEGER, enumType: EventSentiment::class)]
        private EventSentiment $sentiment = EventSentiment::SENTIMENT_0,
        #[ORM\Column(nullable: true)]
        private ?float $location_x = null,
        #[ORM\Column(nullable: true)]
        private ?float $locationY = null,
        #[ORM\Column(nullable: true)]
        private ?float $locationRadius = null,
        #[ORM\Column(nullable: true)]
        private ?\DateTimeImmutable $startedAt = null,
        #[ORM\Column]
        private \DateTimeImmutable $created_at = new \DateTimeImmutable(),
    ) {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection<int, News>
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): void
    {
        if (!$this->news->contains($news)) {
            $this->news->add($news);
            $news->addEvent($this);
        }
    }

    public function removeNews(News $news): void
    {
        $this->news->removeElement($news);
    }

    public function getWeight(): EventWeight
    {
        return $this->weight;
    }

    public function setWeight(EventWeight $weight): void
    {
        $this->weight = $weight;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getSentiment(): EventSentiment
    {
        return $this->sentiment;
    }

    public function setSentiment(EventSentiment $sentiment): void
    {
        $this->sentiment = $sentiment;
    }

    public function getLocationX(): ?float
    {
        return $this->location_x;
    }

    public function setLocationX(?float $location_x): void
    {
        $this->location_x = $location_x;
    }

    public function getLocationY(): ?float
    {
        return $this->locationY;
    }

    public function setLocationY(?float $locationY): void
    {
        $this->locationY = $locationY;
    }

    public function getLocationRadius(): ?float
    {
        return $this->locationRadius;
    }

    public function setLocationRadius(?float $locationRadius): void
    {
        $this->locationRadius = $locationRadius;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeImmutable $startedAt): void
    {
        $this->startedAt = $startedAt;
    }
}
