<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\HubSpot;

use Proximum\Vimeet365\Core\Application\Hubspot\Model\Company as HubspotCompany;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Symfony\Component\Asset\PackageInterface;

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

    public function __construct(
        HubspotCompany $hubspotCompany,
        ?Company $existingCompany,
        PackageInterface $logoUrlProvider
    ) {
        $this->hubspotId = (string) $hubspotCompany->id;

        $this->name = $hubspotCompany->properties['name'];
        $this->country = $hubspotCompany->properties['country'];
        $this->website = $hubspotCompany->properties['website'];

        if ($existingCompany !== null) {
            $this->id = $existingCompany->getId();
            $this->name = $existingCompany->getName();
            $this->logo = $existingCompany->getLogo() !== null ? $logoUrlProvider->getUrl($existingCompany->getLogo()) : null;
            $this->country = $existingCompany->getCountryCode();
            $this->countryCode = $existingCompany->getCountryCode();
            $this->website = $existingCompany->getWebsite();
            $this->existing = true;
        }
    }
}
