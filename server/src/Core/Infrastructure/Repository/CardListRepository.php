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
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;

/**
 * @extends ServiceEntityRepository<CardList>
 */
class CardListRepository extends ServiceEntityRepository implements CardListRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardList::class);
    }

    public function findOneByCommunityAndId(int $communityId, int $cardListId): ?CardList
    {
        return $this->findOneBy([
            'community' => $communityId,
            'id' => $cardListId,
            'published' => true,
        ]);
    }

    public function add(CardList $cardList): void
    {
        $this->getEntityManager()->persist($cardList);
    }

    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface
    {
        $queryBuilder = $this->createQueryBuilder('cardList');

        $queryBuilder
            ->leftJoin('cardList.community', 'community')
            ->addSelect('community')
        ;

        $this->applyFilters($queryBuilder, $filters);
        $this->applyOrderBy($queryBuilder, $orderBy);

        return DoctrineORMPaginator::createFromQueryBuilder($queryBuilder, $pagination);
    }

    private function applyFilters(QueryBuilder $queryBuilder, array $filters, string $alias = 'cardList'): void
    {
        if ($filters['community'] ?? null) {
            $queryBuilder
                ->andWhere($alias . '.community = :community')
                ->setParameter('community', $filters['community'])
            ;
        }
    }

    private function applyOrderBy(QueryBuilder $queryBuilder, array $orderBy, string $alias = 'cardList'): void
    {
        foreach ($orderBy as $field => $direction) {
            $direction = null !== $direction ? strtoupper($direction) : null;

            if (!\in_array($direction, [Criteria::ASC, Criteria::DESC], true)) {
                $direction = Criteria::ASC;
            }

            $queryBuilder->addOrderBy($field, $direction);
        }

        if (\count($orderBy) === 0) {
            $queryBuilder->addOrderBy("$alias.id", Criteria::ASC);
        }

        $queryBuilder->addOrderBy("$alias.id", Criteria::DESC);
    }
}
