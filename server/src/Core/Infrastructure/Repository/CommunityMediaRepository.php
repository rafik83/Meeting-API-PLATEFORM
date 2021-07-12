<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Common\Pagination\DoctrineORMPaginator;
use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Common\Pagination\PaginatorInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityMediaRepositoryInterface;

/**
 * @template-extends ServiceEntityRepository<Media>
 */
class CommunityMediaRepository extends ServiceEntityRepository implements CommunityMediaRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    public function getSortedByName(Community $community, int $limit): array
    {
        $locale = \Locale::getDefault();

        $queryBuilder = $this->createQueryBuilder('media');
        $queryBuilder
            ->innerJoin('media.translations', 'translation', Join::WITH, 'translation.language = :locale')
            ->andWhere('media.community = :community')
            ->andWhere('media.published = true')
            ->andWhere('media.processed = true')
            ->setParameter('community', $community)
            ->setParameter('locale', $locale)
            ->orderBy('translation.name', 'ASC')
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function getSortedByDate(Community $community, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('media');
        $queryBuilder
            ->andWhere('media.community = :community')
            ->andWhere('media.published = true')
            ->andWhere('media.processed = true')
            ->setParameter('community', $community)
            ->orderBy('media.createdAt', 'ASC')
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function add(Media $media, bool $flush = false): void
    {
        $this->getEntityManager()->persist($media);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Media $media): void
    {
        $this->getEntityManager()->remove($media);
    }

    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface
    {
        $queryBuilder = $this->createQueryBuilder('community_media');

        $this->applyFilters($queryBuilder, $filters);
        $this->applyOrderBy($queryBuilder, $orderBy);

        return DoctrineORMPaginator::createFromQueryBuilder($queryBuilder, $pagination);
    }

    private function applyFilters(QueryBuilder $queryBuilder, array $filters, string $alias = 'community_media'): void
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

    private function applyOrderBy(QueryBuilder $queryBuilder, array $orderBy, string $alias = 'community_media'): void
    {
        foreach ($orderBy as $field => $direction) {
            $direction = null !== $direction ? strtoupper($direction) : null;

            if (!\in_array($direction, [Criteria::ASC, Criteria::DESC], true)) {
                $direction = Criteria::ASC;
            }

            $queryBuilder->addOrderBy($field, $direction);
        }

        $queryBuilder->addOrderBy("$alias.id", Criteria::DESC);
    }

    public function findOneByIdAndCommunity(int $mediaId, int $communityId): ?Media
    {
        return $this->findOneBy(['id' => $mediaId, 'community' => $communityId]);
    }

    public function findOneById(int $id): ?Media
    {
        return $this->find($id);
    }
}
