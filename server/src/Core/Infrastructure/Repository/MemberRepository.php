<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList\Config;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
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

    public function getSortedByName(Community $community, ?Config $config, int $limit): array
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

        if ($config instanceof Community\CardList\MemberConfig) {
            $this->filterByMainGoal($queryBuilder, $config->getMainGoal());
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function getSortedByDate(Community $community, ?Config $config, int $limit): array
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

        if ($config instanceof Community\CardList\MemberConfig) {
            $this->filterByMainGoal($queryBuilder, $config->getMainGoal());
        }

        return $queryBuilder->getQuery()->getResult();
    }

    private function filterByMainGoal(QueryBuilder $queryBuilder, ?Tag $mainGoal): void
    {
        if ($mainGoal === null) {
            return;
        }

        $queryBuilder
            ->innerJoin('m.goals', 'goal', Join::WITH, 'goal.priority = 0')
            ->innerJoin('goal.communityGoal', 'communityGoal', Join::WITH, 'communityGoal.parent IS NULL')
            ->andWhere('goal.tag = :mainGoal')
            ->setParameter('mainGoal', $mainGoal)
        ;
    }
}
