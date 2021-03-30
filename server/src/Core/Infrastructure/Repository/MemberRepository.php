<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Member;
use Proximum\Vimeet365\Core\Domain\Repository\MemberRepositoryInterface;

class MemberRepository extends ServiceEntityRepository implements MemberRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    public function add(Member $member): void
    {
        $this->getEntityManager()->persist($member);
    }

    public function findOneById(int $id): ?Member
    {
        return $this->find($id);
    }
}
