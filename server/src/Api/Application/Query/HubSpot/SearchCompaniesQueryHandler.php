<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query\HubSpot;

use Proximum\Vimeet365\Api\Application\View\HubSpot\CompanyView;
use Proximum\Vimeet365\Core\Application\Filesystem\Assets;
use Proximum\Vimeet365\Core\Application\Hubspot\ClientInterface;
use Proximum\Vimeet365\Core\Application\Hubspot\Model\Company as HubspotCompany;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;
use Symfony\Component\Asset\Packages;

class SearchCompaniesQueryHandler
{
    private ClientInterface $hubspot;
    private CompanyRepositoryInterface $companyRepository;
    private Packages $assetPackages;

    public function __construct(ClientInterface $hubspot, CompanyRepositoryInterface $companyRepository, Packages $assetPackages)
    {
        $this->hubspot = $hubspot;
        $this->companyRepository = $companyRepository;
        $this->assetPackages = $assetPackages;
    }

    public function __invoke(SearchCompaniesQuery $query): array
    {
        $companies = $this->hubspot->findCompaniesByDomain($query->domain, $query->limit);

        $hubspotIds = array_map(static fn (HubspotCompany $company) => (string) $company->id, $companies);

        $existingCompanies = $this->companyRepository->findByHubspotIds($hubspotIds);

        return array_map(
            fn (HubspotCompany $hubspotCompany) => new CompanyView(
                $hubspotCompany,
                $existingCompanies[$hubspotCompany->id] ?? null,
                $this->assetPackages->getPackage(Assets::COMPANY_LOGOS)
            ),
            $companies
        );
    }
}
