<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 */
class NewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function countByEvent(Event $event): int
    {
        /** @var int $result */
        $result = $this->createQueryBuilder('news')
            ->select('COUNT(news.id)')
            ->leftJoin('news.events', 'event')
            ->andWhere('event.id = :event')
            ->setParameter('event', $event)
            ->getQuery()
            ->getSingleScalarResult();

        return $result;
    }

    public function save(News $news): void
    {
        $this->getEntityManager()->persist($news);
        $this->getEntityManager()->flush();
    }

    public function getAverageNumberOfNewsPerEvent(): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT AVG(news_count) as avg_news_per_event
            FROM (
                SELECT COUNT(news_id) as news_count
                FROM event e
                LEFT JOIN event_news n ON n.event_id = e.id
                GROUP BY e.id
            ) as sub';

        $stmt = $conn->executeQuery($sql);
        /** @var int $avg */
        $avg = $stmt->fetchOne();

        return $avg;
    }
}
