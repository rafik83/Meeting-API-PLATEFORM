<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityEventRepositoryInterface;

/**
 * @template-extends ServiceEntityRepository<Event>
 */
class CommunityEventRepository extends ServiceEntityRepository implements CommunityEventRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getSortedByName(Community $community, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('event');
        $queryBuilder
            ->andWhere('event.community = :community')
            ->andWhere('event.published = true')
            ->setParameter('community', $community)
            ->orderBy('event.name', 'ASC')
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function getSortedByDate(Community $community, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('event');
        $queryBuilder
            ->andWhere('event.community = :community')
            ->andWhere('event.published = true')
            ->setParameter('community', $community)
            ->orderBy('event.startDate', 'ASC')
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
