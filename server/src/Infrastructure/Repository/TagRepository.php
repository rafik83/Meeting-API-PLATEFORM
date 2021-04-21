<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Domain\Entity\Tag;
use Proximum\Vimeet365\Domain\Repository\TagRepositoryInterface;

class TagRepository extends ServiceEntityRepository implements TagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function findOneByExternalId(string $id): ?Tag
    {
        return $this->findOneBy(['externalId' => $id]);
    }

    public function getOneById(int $id): Tag
    {
        $queryBuilder = $this->createQueryBuilder('tag');

        $queryBuilder
            ->where('tag.id = :id')
            ->setParameter('id', $id);

        return $queryBuilder->getQuery()->getSingleResult();
    }

    public function findByIds(array $tagsId): array
    {
        if (\count($tagsId) === 0) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('tag');
        $queryBuilder
            ->andWhere($queryBuilder->expr()->in('tag.id', $tagsId))
            ->indexBy('tag', 'tag.id')
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
