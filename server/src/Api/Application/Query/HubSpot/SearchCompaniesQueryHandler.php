<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query\HubSpot;

use Proximum\Vimeet365\Api\Application\View\HubSpot\CompanyView;
use Proximum\Vimeet365\Core\Application\Hubspot\ClientInterface;
use Proximum\Vimeet365\Core\Application\Hubspot\Model\Company as HubspotCompany;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;

class SearchCompaniesQueryHandler
{
    private ClientInterface $hubspot;
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(ClientInterface $hubspot, CompanyRepositoryInterface $companyRepository)
    {
        $this->hubspot = $hubspot;
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(SearchCompaniesQuery $query): array
    {
        $companies = $this->hubspot->findCompaniesByDomain($query->domain, $query->limit);

        $hubspotIds = array_map(static fn (HubspotCompany $company) => (string) $company->id, $companies);

        $existingCompanies = $this->companyRepository->findByHubspotIds($hubspotIds);

        return array_map(
            static fn (HubspotCompany $hubspotCompany) => new CompanyView(
                $hubspotCompany,
                $existingCompanies[$hubspotCompany->id] ?? null
            ),
            $companies
        );
    }
}
