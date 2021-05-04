<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Hubspot\Model;

use Proximum\Vimeet365\Core\Domain\Entity\Company as CompanyEntity;

class Company
{
    public ?string $id;

    /** @var array<string, string> */
    public array $properties;

    public function __construct(?string $id, array $properties = [])
    {
        $this->id = $id;
        $this->properties = $properties;
    }

    public static function fromCompany(CompanyEntity $company): self
    {
        return new self($company->getHubspotId(),
            [
                'name' => $company->getName(),
                'domain' => $company->getDomain(),
                'description' => $company->getActivity(),
                'country' => $company->getCountryCode(),
            ]
        );
    }
}
