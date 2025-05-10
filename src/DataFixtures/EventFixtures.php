<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\EventSentiment;
use App\Entity\News;
use App\Entity\SentimentDetails;
use App\Shared\UuidGeneratorInterface;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator,
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $events = $this->parseFile();


        foreach ($events['events'] as $event) {
            $news = $this->createNews($event['news']);

            $eventEntity = new Event(
                $this->uuidGenerator->generate(),
                $event['title'],
                $event['description'],
                false,
                $event['category'],
                $news
            );

            $sentiment = $this->createSentiment($eventEntity, $event['sentiment']);
            $eventEntity->setSentiment($sentiment);

            $manager->persist($eventEntity);
        }

        $manager->flush();
    }

    private function parseFile(): array
    {
        $path = __DIR__ . '/data.json';

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON: ' . json_last_error_msg());
        }

        return $data;
    }

    private function createNews(array $arrayOfNews): ArrayCollection
    {
        $news = [];

        foreach ($arrayOfNews as $newsItem) {
            $news[] = new News(
                $this->uuidGenerator->generate(),
                $newsItem['content'],
                $newsItem['title'],
                new DateTimeImmutable($newsItem['publishedAt']),
                new DateTimeImmutable()
            );
        }

        return new ArrayCollection($news);
    }

    private function createSentiment(Event $event, array $sentiment): EventSentiment
    {
        return new EventSentiment(
            $this->uuidGenerator->generate(),
            $event,
            new SentimentDetails(
                $this->uuidGenerator->generate(),
                $sentiment['agitation']['strength'],
                $sentiment['agitation']['detectedEmotions'],
            ),
            new SentimentDetails(
                $this->uuidGenerator->generate(),
                $sentiment['neutral']['strength'],
                $sentiment['neutral']['detectedEmotions'],
            ),
            new SentimentDetails(
                $this->uuidGenerator->generate(),
                $sentiment['positive']['strength'],
                $sentiment['positive']['detectedEmotions'],
            ),
        );
    }
}
