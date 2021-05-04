<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Hubspot;

use Proximum\Vimeet365\Core\Application\Hubspot\Model\Company;
use Proximum\Vimeet365\Core\Application\Hubspot\Model\Contact;

interface ClientInterface
{
    public function findContact(string $email): ?Contact;

    public function createContact(Contact $contact): Contact;

    public function getContactCompanyId(string $id): ?string;

    public function findCompany(string $id): ?Company;

    /**
     * @param int $limit must be < 100
     *
     * @return Company[]
     */
    public function findCompaniesByDomain(string $domain, int $limit = 10): array;

    public function linkContactAndCompany(string $contactId, string $companyId): void;

    public function createCompany(Company $company): Company;
}
