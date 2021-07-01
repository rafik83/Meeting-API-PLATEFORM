<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;

/**
 * @template-extends ServiceEntityRepository<Company>
 */
class CompanyRepository extends ServiceEntityRepository implements CompanyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function findOneById(int $id): ?Company
    {
        return $this->find($id);
    }

    public function add(Company $company): void
    {
        $this->getEntityManager()->persist($company);
    }

    public function findOneByHubspotId(string $hubspotId): ?Company
    {
        return $this->findOneBy(['hubspotId' => $hubspotId]);
    }

    public function findOneByDomain(string $domain): ?Company
    {
        return $this->findOneBy(['domain' => $domain]);
    }

    public function findByDomain(string $domain, ?int $limit): array
    {
        return $this->findBy(['domain' => $domain], null, $limit);
    }

    public function findByHubspotIds(array $hubspotIds = []): array
    {
        $queryBuilder = $this->createQueryBuilder('company');

        if (\count($hubspotIds) === 0) {
            return [];
        }

        $queryBuilder
            ->indexBy('company', 'company.hubspotId')
            ->andWhere($queryBuilder->expr()->in('company.hubspotId', $hubspotIds))
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function getSortedByName(Community $community, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('company');
        $queryBuilder
            ->andWhere($queryBuilder->expr()->exists(
                'SELECT m  FROM ' . Member::class . ' m JOIN m.account account 
                WHERE m.community = :community AND account.company = company.id
            '))
            ->orderBy('company.name', 'ASC')
            ->setParameter('community', $community)
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function getSortedByDate(Community $community, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('company');
        $queryBuilder
            ->andWhere($queryBuilder->expr()->exists(
                'SELECT m  FROM ' . Member::class . ' m JOIN m.account account 
                WHERE m.community = :community AND account.company = company.id
            '))
            ->orderBy('company.createdAt', 'DESC')
            ->setParameter('community', $community)
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
