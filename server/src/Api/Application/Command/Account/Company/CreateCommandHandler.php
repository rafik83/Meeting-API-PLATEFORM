<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account\Company;

use Proximum\Vimeet365\Common\Messenger\EventBusInterface;
use Proximum\Vimeet365\Core\Application\Event\Hubspot\AccountCompanyLinkedEvent;
use Proximum\Vimeet365\Core\Application\Event\Hubspot\CompanyCreatedEvent;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;

class CreateCommandHandler
{
    private CompanyRepositoryInterface $companyRepository;
    private EventBusInterface $eventBus;

    public function __construct(CompanyRepositoryInterface $companyRepository, EventBusInterface $eventBus)
    {
        $this->companyRepository = $companyRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateCommand $command): Account
    {
        $company = new Company($command->name, $command->countryCode, $command->website, $command->activity);
        $company->setHubspotId($command->hubspotId);

        $command->account->setCompany($company);

        $this->companyRepository->add($company);

        $this->eventBus->dispatch(new CompanyCreatedEvent($company));
        $this->eventBus->dispatch(new AccountCompanyLinkedEvent($command->account, $company));

        return $command->account;
    }
}
