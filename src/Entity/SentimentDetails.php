<?php

namespace App\Entity;

use App\Repository\SentimentDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SentimentDetailsRepository::class)]
readonly class SentimentDetails
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME, unique: true)]
        private Uuid $id,
        #[ORM\Column]
        private int $strength,
        #[ORM\Column(type: Types::JSON)]
        private array $detectedEmotions = [],
    ) {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function getDetectedEmotions(): array
    {
        return $this->detectedEmotions;
    }
}
