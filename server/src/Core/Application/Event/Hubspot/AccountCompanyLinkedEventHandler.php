<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Event\Hubspot;

use Proximum\Vimeet365\Core\Application\Hubspot\ClientInterface;
use Proximum\Vimeet365\Core\Domain\Repository\AccountRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;
use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class AccountCompanyLinkedEventHandler
{
    private AccountRepositoryInterface $accountRepository;
    private CompanyRepositoryInterface $companyRepository;
    private ClientInterface $hubspot;

    private bool $hubspotEnabled;

    public function __construct(
        AccountRepositoryInterface $accountRepository,
        CompanyRepositoryInterface $companyRepository,
        ClientInterface $hubspot,
        bool $hubspotEnabled = true
    ) {
        $this->accountRepository = $accountRepository;
        $this->hubspot = $hubspot;
        $this->companyRepository = $companyRepository;
        $this->hubspotEnabled = $hubspotEnabled;
    }

    public function __invoke(AccountCompanyLinkedEvent $event): void
    {
        if (!$this->hubspotEnabled) {
            return;
        }

        $account = $this->accountRepository->findOneByEmail($event->email);
        if ($account === null) {
            throw new UnrecoverableMessageHandlingException(sprintf('The account %s does not exist', $event->email));
        }

        if ($account->getHubspotId() === null) {
            throw new RecoverableMessageHandlingException(sprintf('The account %s has not yet receive its hubspotId', $event->email));
        }

        $company = $this->companyRepository->findOneByDomain($event->companyDomain);
        if ($company === null) {
            throw new UnrecoverableMessageHandlingException(sprintf('The company %s does not exist', $event->companyDomain));
        }

        if ($company->getHubspotId() === null) {
            throw new RecoverableMessageHandlingException(sprintf('The company %s has not yet receive its hubspotId', $event->companyDomain));
        }

        $this->hubspot->linkContactAndCompany($account->getHubspotId(), $company->getHubspotId());
    }
}
