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
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureRepositoryInterface;

/**
 * @template-extends ServiceEntityRepository<Nomenclature>
 */
class NomenclatureRepository extends ServiceEntityRepository implements NomenclatureRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nomenclature::class);
    }

    public function findOneById(int $id): ?Nomenclature
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findJobPositionNomenclature(): ?Nomenclature
    {
        return $this->findOneBy(['reference' => Nomenclature::JOB_POSITION_NOMENCLATURE, 'community' => null]);
    }

    public function add(Nomenclature $nomenclature): void
    {
        $this->getEntityManager()->persist($nomenclature);
    }

    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface
    {
        $queryBuilder = $this->createQueryBuilder('nomenclature');

        $queryBuilder
            ->leftJoin('nomenclature.community', 'community')
            ->addSelect('community')
        ;

        $this->applyFilters($queryBuilder, $filters);
        $this->applyOrderBy($queryBuilder, $orderBy);

        return DoctrineORMPaginator::createFromQueryBuilder($queryBuilder, $pagination);
    }

    private function applyFilters(QueryBuilder $queryBuilder, array $filters, string $alias = 'nomenclature'): void
    {
        if ($filters['community'] ?? null) {
            $queryBuilder
                ->andWhere($alias . '.community = :community')
                ->setParameter('community', $filters['community'])
            ;
        }

        if ($filters['reference'] ?? null) {
            $queryBuilder
                ->andWhere($alias . '.reference LIKE :reference')
                ->setParameter('reference', '%' . $filters['reference'] . '%')
            ;
        }
    }

    private function applyOrderBy(QueryBuilder $queryBuilder, array $orderBy, string $alias = 'nomenclature'): void
    {
        foreach ($orderBy as $field => $direction) {
            $direction = null !== $direction ? strtoupper($direction) : null;

            if (!\in_array($direction, [Criteria::ASC, Criteria::DESC], true)) {
                $direction = Criteria::ASC;
            }

            $queryBuilder->addOrderBy($field, $direction);
        }

        if (\count($orderBy) === 0) {
            $queryBuilder->addOrderBy("$alias.reference", Criteria::ASC);
        }

        $queryBuilder->addOrderBy("$alias.id", Criteria::DESC);
    }

    public function getFirstLevelNomenclatureQueryBuilder(Community $community): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('nomenclature');
        $queryBuilder
            ->andWhere('nomenclature.community = :community')
            ->andWhere('nomenclature.id NOT IN (
                            SELECT IDENTITY(nomenclatureTag.nomenclature)
                            FROM ' . Nomenclature\NomenclatureTag::class . ' nomenclatureTag
                            JOIN nomenclatureTag.nomenclature n
                            WHERE nomenclatureTag.parent IS NOT NULL
                              AND n.community = :community
                        )')
            ->setParameter('community', $community);

        return $queryBuilder;
    }
}
