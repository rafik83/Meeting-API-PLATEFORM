<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Application\Repository\CommunityRepositoryInterface;
use Proximum\Vimeet365\Entity\Community;

class CommunityRepository extends ServiceEntityRepository implements CommunityRepositoryInterface
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Community::class);
    }

    public function findById(int $id): ?Community
    {
        return $this->find($id);
    }
}
