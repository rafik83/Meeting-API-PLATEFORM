<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Event\Hubspot;

use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Entity\Company;

class AccountCompanyLinkedEvent
{
    public string $email;
    public string $companyDomain;

    public function __construct(Account $account, Company $company)
    {
        $this->email = $account->getEmail();
        $this->companyDomain = $company->getDomain();
    }
}
