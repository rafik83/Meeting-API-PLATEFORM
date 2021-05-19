<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View;

use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\Intl\Countries;

class CompanyView
{
    public int $id;
    public string $name;
    public string $countryCode;
    public string $country;
    public string $website;
    public string $domain;
    public string $activity;
    public ?string $logo;

    public function __construct(
        int $id,
        string $name,
        string $countryCode,
        string $country,
        string $website,
        string $domain,
        string $activity,
        ?string $logo
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->countryCode = $countryCode;
        $this->country = $country;
        $this->website = $website;
        $this->domain = $domain;
        $this->activity = $activity;
        $this->logo = $logo;
    }

    public static function createFromCompany(Company $company, PackageInterface $logoUrlProvider): self
    {
        return new self(
            (int) $company->getId(),
            $company->getName(),
            $company->getCountryCode(),
            Countries::getName($company->getCountryCode()),
            $company->getWebsite(),
            $company->getDomain(),
            $company->getActivity(),
            $company->getLogo() !== null ? $logoUrlProvider->getUrl($company->getLogo()) : null
        );
    }
}
