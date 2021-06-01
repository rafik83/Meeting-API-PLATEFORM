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
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;

/**
 * @template-extends ServiceEntityRepository<Community>
 */
class CommunityRepository extends ServiceEntityRepository implements CommunityRepositoryInterface
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Community::class);
    }

    public function findOneById(int $id): ?Community
    {
        return $this->find($id);
    }

    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface
    {
        $queryBuilder = $this->createQueryBuilder('community');

        $this->applyFilters($queryBuilder, $filters);
        $this->applyOrderBy($queryBuilder, $orderBy);

        return DoctrineORMPaginator::createFromQueryBuilder($queryBuilder, $pagination);
    }

    private function applyFilters(QueryBuilder $queryBuilder, array $filters, string $alias = 'community'): void
    {
    }

    private function applyOrderBy(QueryBuilder $queryBuilder, array $orderBy, string $alias = 'community'): void
    {
        foreach ($orderBy as $field => $direction) {
            $direction = null !== $direction ? strtoupper($direction) : null;

            if (!\in_array($direction, [Criteria::ASC, Criteria::DESC], true)) {
                $direction = Criteria::ASC;
            }

            $queryBuilder->addOrderBy($field, $direction);
        }

        if (\count($orderBy) === 0) {
            $queryBuilder->addOrderBy("$alias.name", Criteria::ASC);
        }

        $queryBuilder->addOrderBy("$alias.id", Criteria::DESC);
    }
}
