<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Domain\Repository\NomenclatureTagRepositoryInterface;

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
