<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Common\Pagination\DoctrineORMPaginator;
use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Common\Pagination\PaginatorInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList\Config;
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

    public function getSortedByName(Community $community, ?Config $config, int $limit): array
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

    public function getSortedByDate(Community $community, ?Config $config, int $limit): array
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

    public function add(Event $event, bool $flush = false): void
    {
        $this->getEntityManager()->persist($event);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $event): void
    {
        $this->getEntityManager()->remove($event);
    }

    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface
    {
        $queryBuilder = $this->createQueryBuilder('community_event');

        $this->applyFilters($queryBuilder, $filters);
        $this->applyOrderBy($queryBuilder, $orderBy);

        return DoctrineORMPaginator::createFromQueryBuilder($queryBuilder, $pagination);
    }

    private function applyFilters(QueryBuilder $queryBuilder, array $filters, string $alias = 'community_event'): void
    {
        if ($filters['community'] ?? null) {
            $queryBuilder
                ->andWhere($alias . '.community = :community')
                ->setParameter('community', $filters['community'])
            ;
        }

        if (isset($filters['published'])) {
            $queryBuilder
                ->andWhere($alias . '.published = :published')
                ->setParameter('published', $filters['published'])
            ;
        }
    }

    private function applyOrderBy(QueryBuilder $queryBuilder, array $orderBy, string $alias = 'community_event'): void
    {
        foreach ($orderBy as $field => $direction) {
            $direction = null !== $direction ? strtoupper($direction) : null;

            if (!\in_array($direction, [Criteria::ASC, Criteria::DESC], true)) {
                $direction = Criteria::ASC;
            }

            $queryBuilder->addOrderBy($field, $direction);
        }

        if (\count($orderBy) === 0) {
            $queryBuilder->addOrderBy("$alias.startDate", Criteria::ASC);
        }

        $queryBuilder->addOrderBy("$alias.id", Criteria::DESC);
    }

    public function findOneByIdAndCommunity(int $eventId, int $communityId): ?Event
    {
        return $this->findOneBy(['id' => $eventId, 'community' => $communityId]);
    }
}
