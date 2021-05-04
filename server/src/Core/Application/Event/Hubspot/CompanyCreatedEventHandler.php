<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Event\Hubspot;

use Proximum\Vimeet365\Core\Application\Hubspot\ClientInterface;
use Proximum\Vimeet365\Core\Application\Hubspot\Model\Company;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;
use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class CompanyCreatedEventHandler
{
    private CompanyRepositoryInterface $companyRepository;
    private ClientInterface $hubspot;

    private bool $hubspotEnabled;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        ClientInterface $hubspot,
        bool $hubspotEnabled = true
    ) {
        $this->companyRepository = $companyRepository;
        $this->hubspot = $hubspot;
        $this->hubspotEnabled = $hubspotEnabled;
    }

    public function __invoke(CompanyCreatedEvent $event): void
    {
        if (!$this->hubspotEnabled) {
            return;
        }

        $company = $this->companyRepository->findOneByDomain($event->domain);
        if ($company === null) {
            throw new UnrecoverableMessageHandlingException(sprintf('The company %s does not exist', $event->domain));
        }

        if ($company->getHubspotId() !== null) {
            return;
        }

        $hubspotCompany = $this->hubspot->createCompany(Company::fromCompany($company));
        if ($hubspotCompany->id === null) {
            throw new RecoverableMessageHandlingException(sprintf('Unable to create the company "%s" on hubspot, retrying later.', $event->domain));
        }

        $company->setHubspotId($hubspotCompany->id);
    }
}
