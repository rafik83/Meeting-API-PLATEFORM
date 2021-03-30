<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureRepositoryInterface;

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
}
