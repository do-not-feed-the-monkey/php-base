<?php

namespace App\Cli\QualifySentiment;

use App\Entity\Event;
use App\Entity\EventSentiment;
use App\Entity\News;
use App\Entity\SentimentDetails;
use App\Repository\EventRepositoryInterface;
use App\Repository\EventSentimentRepositoryInterface;
use App\Shared\UuidGeneratorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:qualify-sentiment',
    description: 'Add a short description for your command',
)]
class QualifySentimentCommand extends Command
{
    public function __construct(
        private readonly string $sentimentQualifyUrl,
        private readonly HttpClientInterface $client,
        private readonly EventRepositoryInterface $eventRepository,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly EventSentimentRepositoryInterface $eventSentimentRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('Obtaining unqualified event data');

        $event = $this->eventRepository->getOldestUnqualifiedEvent();

        $news = $event->getNews()->map(fn(News $news) => $news->getContent())->toArray();

        $newsString = implode("\n", $news);

//        $response = $this->client->request('POST', $this->sentimentQualifyUrl, [
//            'body' => [
//                'title' => $event->getTitle(),
//                'description' => $event->getDescription(),
//                'last_ten_news' => $newsString
//            ],
//        ]);

//        $content = $response->getContent();

//        $decodedContent = json_decode($content, true);

        $decodedContent = [
            'agitation' => [
                'strength' => 10,
                'detectedEmotions' => ['joy']
            ],
            'neutral' => [
                'strength' => 10,
                'detectedEmotions' => ['happiness']
            ],
            'positive' => [
                'strength' => 10,
                'detectedEmotions' => ['fear']
            ]
        ];

        $eventSentiment = $this->createEventSentiment($event, $decodedContent);

        $this->eventSentimentRepository->save($eventSentiment);

        return Command::SUCCESS;
    }

    private function createEventSentiment(Event $event, array $data): EventSentiment
    {
        return new EventSentiment(
            $this->uuidGenerator->generate(),
            $event,
            new SentimentDetails(
                $this->uuidGenerator->generate(),
                $data['agitation']['strength'],
                $data['agitation']['detectedEmotions'],
            ),
            new SentimentDetails(
                $this->uuidGenerator->generate(),
                $data['neutral']['strength'],
                $data['neutral']['detectedEmotions'],
            ),
            new SentimentDetails(
                $this->uuidGenerator->generate(),
                $data['positive']['strength'],
                $data['positive']['detectedEmotions'],
            ),
        );
    }
}

