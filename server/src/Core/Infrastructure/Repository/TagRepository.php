<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Domain\Repository\TagRepositoryInterface;

/**
 * @template-extends ServiceEntityRepository<Tag>
 */
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

    public function getTagThatBelongToANomenclatureQueryBuilder(Nomenclature $nomenclature): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('tag');

        $nomenclatureTag = NomenclatureTag::class;
        $subQuery = <<<DQL
            SELECT IDENTITY(nomenclatureTag.tag)
            FROM {$nomenclatureTag} nomenclatureTag
            WHERE nomenclatureTag.nomenclature = :nomenclature
DQL;

        $queryBuilder
            ->andWhere($queryBuilder->expr()->in('tag.id', $subQuery))
            ->setParameter('nomenclature', $nomenclature)
        ;

        return $queryBuilder;
    }
}
