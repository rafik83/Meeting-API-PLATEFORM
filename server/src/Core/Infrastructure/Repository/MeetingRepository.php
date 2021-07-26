<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Meeting;

/**
 * @template-extends ServiceEntityRepository<Meeting>
 */
class MeetingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meeting::class);
    }

    public function add(Meeting $meeting): void
    {
        $this->getEntityManager()->persist($meeting);
    }

    public function findOneById(int $id): ?Meeting
    {
        return $this->find($id);
    }
}
