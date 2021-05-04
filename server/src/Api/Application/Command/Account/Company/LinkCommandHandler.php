<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account\Company;

use Proximum\Vimeet365\Common\Messenger\EventBusInterface;
use Proximum\Vimeet365\Core\Application\Event\Hubspot\AccountCompanyLinkedEvent;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;

class LinkCommandHandler
{
    private CompanyRepositoryInterface $companyRepository;
    private EventBusInterface $eventBus;

    public function __construct(CompanyRepositoryInterface $companyRepository, EventBusInterface $eventBus)
    {
        $this->companyRepository = $companyRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(LinkCommand $command): Account
    {
        $account = $command->account;

        $company = $this->companyRepository->findOneById($command->company);
        if ($company === null) {
            throw new \RuntimeException(sprintf('Unable to find the company %d', $command->company));
        }

        $account->setCompany($company);

        $this->eventBus->dispatch(new AccountCompanyLinkedEvent($account, $company));

        return $account;
    }
}
