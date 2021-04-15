<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Domain\Entity\Company;
use Proximum\Vimeet365\Domain\Repository\CompanyRepositoryInterface;

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
}
