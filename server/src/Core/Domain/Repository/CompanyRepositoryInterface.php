<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Company;

interface CompanyRepositoryInterface
{
    public function findOneById(int $id): ?Company;

    public function add(Company $company): void;

    public function findOneByHubspotId(string $hubspotId): ?Company;

    public function findOneByDomain(string $domain): ?Company;

    /**
     * @return Company[]
     */
    public function findByDomain(string $domain, ?int $limit): array;

    /**
     * @param string[] $hubspotIds
     *
     * @return array<string, Company> indexed by hubspotId
     */
    public function findByHubspotIds(array $hubspotIds = []): array;
}
