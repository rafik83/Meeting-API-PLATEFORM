<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureTagRepositoryInterface;

/**
 * @template-extends ServiceEntityRepository<NomenclatureTag>
 */
class NomenclatureTagRepository extends ServiceEntityRepository implements NomenclatureTagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NomenclatureTag::class);
    }

    public function findOneByExternalId(string $id): ?NomenclatureTag
    {
        return $this->findOneBy(['externalId' => $id]);
    }
}
