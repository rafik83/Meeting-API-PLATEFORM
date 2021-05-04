<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\HubSpot;

use Proximum\Vimeet365\Core\Application\Hubspot\Model\Company as HubspotCompany;
use Proximum\Vimeet365\Core\Domain\Entity\Company;

class CompanyView
{
    public ?int $id = null;
    public string $hubspotId;
    public string $name;
    public ?string $logo = null;
    public ?string $country = null;
    public ?string $countryCode = null;
    public string $website;
    public bool $existing = false;

    public function __construct(HubspotCompany $hubspotCompany, ?Company $existingCompany)
    {
        $this->hubspotId = (string) $hubspotCompany->id;

        $this->name = $hubspotCompany->properties['name'];
        $this->country = $hubspotCompany->properties['country'];
        $this->website = $hubspotCompany->properties['website'];

        if ($existingCompany !== null) {
            $this->id = $existingCompany->getId();
            $this->name = $existingCompany->getName();
            // @todo how to handle logo with the external storage
            $this->logo = $existingCompany->getLogo();
            $this->country = $existingCompany->getCountryCode();
            $this->countryCode = $existingCompany->getCountryCode();
            $this->website = $existingCompany->getWebsite();
            $this->existing = true;
        }
    }
}
