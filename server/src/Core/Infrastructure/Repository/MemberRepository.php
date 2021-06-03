<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Member;
use Proximum\Vimeet365\Core\Domain\Repository\MemberRepositoryInterface;

/**
 * @template-extends ServiceEntityRepository<Member>
 */
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

    public function getSortedByName(Community $community, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder
            ->select('m', 'account')
            ->join('m.account', 'account')
            ->andWhere('m.community = :community')
            ->orderBy('account.lastName', 'ASC')
            ->addOrderBy('account.firstName', 'ASC')
            ->setParameter('community', $community)
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function getSortedByDate(Community $community, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder
            ->select('m', 'account')
            ->join('m.account', 'account')
            ->andWhere('m.community = :community')
            ->orderBy('m.joinedAt', 'DESC')
            ->setParameter('community', $community)
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
