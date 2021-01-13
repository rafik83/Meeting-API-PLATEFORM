<?php

namespace Proximum\Vimeet365\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Entity\Community;
use Proximum\Vimeet365\Application\Repository\CommunityRepositoryInterface;

class CommunityRepository implements CommunityRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    public function findById(int $id): ?Community
    {
        return $this->entityManager->find(Community::class, $id);
    }
}
