<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Slot;

/**
 * @template-extends ServiceEntityRepository<Slot>
 */
class SlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slot::class);
    }
}
