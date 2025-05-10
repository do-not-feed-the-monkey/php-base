<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Enum\EventSentiment;
use App\Entity\Enum\EventWeight;
use App\Entity\Event;
use App\Entity\News;
use App\Shared\UuidGeneratorInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class EventFixtures extends Fixture
{
    public const string WARSAW_EVENT_ID = 'e90d1501-62f6-4b7e-9890-742ff3292c2f';
    public const string KRAKOW_EVENT_ID = 'd6172098-3a77-4e4a-9c51-4c8cd0e405e6';
    public const string GDANSK_EVENT_ID = '7b5f6f1d-41c8-4bd5-89c6-5f7c2a366916';
    public const string KATOWICE_EVENT_ID = '1c3c727b-1394-42e5-a457-f48a49446d77';

    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadWarsawEvent($manager);
        $this->loadKrakowEvent($manager);
        $this->loadGdanskEvent($manager);
        $this->loadKatowiceEvent($manager);
    }

    public function loadWarsawEvent(ObjectManager $objectManager): void
    {
        $news1 = new News(
            $this->uuidGenerator->generate(),
            'What happend in Warsaw?? Was it a fckin plane??',
            null,
            new \DateTimeImmutable('2024-04-04 10:00:00'),
        );

        $news2 = new News(
            $this->uuidGenerator->generate(),
            'Omg, explosion blew windows in palace of culture',
            null,
            new \DateTimeImmutable('2024-04-04 10:15:31'),
        );

        $news3 = new News(
            $this->uuidGenerator->generate(),
            'Where the F is police? People are dying here!!!!',
            null,
            new \DateTimeImmutable('2024-04-04 10:17:56'),
        );

        $news = new ArrayCollection([$news1, $news2, $news3]);

        $event = new Event(
            new Uuid(self::WARSAW_EVENT_ID),
            'Potential explosion in center of Warsaw',
            'Few potential witnesses experienced explosion going off in center of Warsaw. Possible casualties.',
            $news,
            EventWeight::WEIGHT_8,
            EventSentiment::SENTIMENT_10,
            52.23175985143875,
            21.00615969783071,
            0.37,
            new \DateTimeImmutable('2024-04-04 10:00:00'),
        );

        $objectManager->persist($event);
        $objectManager->flush();
    }

    private function loadKrakowEvent(ObjectManager $manager): void
    {
        $news = new ArrayCollection([
            new News($this->uuidGenerator->generate(), 'Large protest in Kraków Main Square', null, new \DateTimeImmutable('2024-05-09 15:00:00')),
            new News($this->uuidGenerator->generate(), 'Police forming barriers near Town Hall Tower.', null, new \DateTimeImmutable('2024-05-09 15:10:00')),
        ]);

        $event = new Event(
            new Uuid(self::KRAKOW_EVENT_ID),
            'Protest in Kraków city center',
            'Crowds gathered in Main Square demanding government reform. Authorities responding to control the situation.',
            $news,
            EventWeight::WEIGHT_7,
            EventSentiment::SENTIMENT_6,
            50.061947,
            19.936856,
            0.48,
            new \DateTimeImmutable('2024-05-09 15:00:00'),
        );

        $manager->persist($event);
        $manager->flush();
    }

    private function loadGdanskEvent(ObjectManager $manager): void
    {
        $news = new ArrayCollection([
            new News($this->uuidGenerator->generate(), 'Explosion at shipyard heard across Gdańsk!', null, new \DateTimeImmutable('2024-05-08 08:42:00')),
            new News($this->uuidGenerator->generate(), 'Several ambulances rushed to the port.', null, new \DateTimeImmutable('2024-05-08 08:45:30')),
        ]);

        $event = new Event(
            new Uuid(self::GDANSK_EVENT_ID),
            'Explosion in Gdańsk shipyard',
            'Unconfirmed reports of an explosion in the shipyard district. Emergency response teams on site.',
            $news,
            EventWeight::WEIGHT_8,
            EventSentiment::SENTIMENT_8,
            54.360214,
            18.649378,
            0.62,
            new \DateTimeImmutable('2024-05-08 08:42:00'),
        );

        $manager->persist($event);
        $manager->flush();
    }

    private function loadKatowiceEvent(ObjectManager $manager): void
    {
        $news = new ArrayCollection([
            new News($this->uuidGenerator->generate(), 'Panic during concert at Spodek Arena.', null, new \DateTimeImmutable('2024-05-07 21:10:00')),
            new News($this->uuidGenerator->generate(), 'People stampeding to exits after fire alarm.', null, new \DateTimeImmutable('2024-05-07 21:12:00')),
        ]);

        $event = new Event(
            new Uuid(self::KATOWICE_EVENT_ID),
            'Evacuation during Katowice concert',
            'Fire alarm caused chaos during major concert at Spodek. Injuries reported from stampede.',
            $news,
            EventWeight::WEIGHT_6,
            EventSentiment::SENTIMENT_7,
            50.264892,
            19.021504,
            0.39,
            new \DateTimeImmutable('2024-05-07 21:10:00'),
        );

        $manager->persist($event);
        $manager->flush();
    }
}
