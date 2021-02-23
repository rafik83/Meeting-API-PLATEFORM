<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Repository\CommunityRepositoryInterface;

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
}
