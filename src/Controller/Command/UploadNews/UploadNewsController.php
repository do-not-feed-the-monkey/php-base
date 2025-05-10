<?php

declare(strict_types=1);

namespace App\Controller\Command\UploadNews;

use App\Controller\Factory\NewsFactoryInterface;
use App\Controller\Shared\ResponseFactory;
use App\Repository\NewsRepositoryInterface;
use App\Shared\UuidGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UploadNewsController extends AbstractController
{
    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ResponseFactory $responseFactory,
    )
    {
    }

    #[Route('/api/news', name: 'upload_news', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] UploadNewsRequest $uploadNewsRequest,
    ): JsonResponse
    {
        $createdNews = [];

        /** @var UploadNewsRequestItem $news */
        foreach ($uploadNewsRequest->news as $news) {
            $createdNews[] = $this->newsFactory->create(
                $this->uuidGenerator->generate(),
                $news->content,
                $news->title,
                $news->publishedAt ? new \DateTimeImmutable($news->publishedAt) : null,
                new \DateTimeImmutable()
            );
        }

        foreach ($createdNews as $createdNew) {
            $this->newsRepository->save($createdNew);
        }

        return $this->responseFactory->accepted();
    }
}
