<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Event\Hubspot;

use Proximum\Vimeet365\Core\Application\Hubspot\ClientInterface;
use Proximum\Vimeet365\Core\Application\Hubspot\Model\Contact;
use Proximum\Vimeet365\Core\Domain\Repository\AccountRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class AccountRegisteredEventHandler
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
        $this->companyRepository = $companyRepository;
        $this->hubspot = $hubspot;
        $this->hubspotEnabled = $hubspotEnabled;
    }

    public function __invoke(AccountRegisteredEvent $event): void
    {
        if (!$this->hubspotEnabled) {
            return;
        }

        $account = $this->accountRepository->findOneByEmail($event->email);
        if ($account === null) {
            throw new UnrecoverableMessageHandlingException(sprintf('The account %s does not exist', $event->email));
        }

        if ($account->getHubspotId() !== null) {
            return;
        }

        $contact = $this->hubspot->findContact($account->getEmail());
        if ($contact === null) {
            $contact = $this->hubspot->createContact(Contact::fromAccount($account));
        }

        if ($contact->id === null) {
            throw new \RuntimeException(sprintf('Unable to create the account "%s" on hubspot, retrying later.', $event->email));
        }

        $companyId = $this->hubspot->getContactCompanyId($contact->id);

        if ($companyId !== null) {
            $company = $this->companyRepository->findOneByHubspotId($companyId);

            $account->setCompany($company);
        }

        $account->setHubspotId($contact->id);
    }
}
