<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Event\Hubspot;

use Proximum\Vimeet365\Core\Domain\Entity\Company;

class CompanyCreatedEvent
{
    public string $domain;

    public function __construct(Company $company)
    {
        $this->domain = $company->getDomain();
    }
}
