<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account;

use Proximum\Vimeet365\Common\Messenger\EventBusInterface;
use Proximum\Vimeet365\Core\Application\Event\Hubspot\AccountRegisteredEvent;
use Proximum\Vimeet365\Core\Application\Security\PasswordEncoderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Repository\AccountRepositoryInterface;

class RegistrationCommandHandler
{
    private AccountRepositoryInterface $accountRepository;
    private PasswordEncoderInterface $passwordEncoder;
    private EventBusInterface $eventBus;

    public function __construct(
        AccountRepositoryInterface $accountRepository,
        PasswordEncoderInterface $passwordEncoder,
        EventBusInterface $eventBus
    ) {
        $this->accountRepository = $accountRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventBus = $eventBus;
    }

    public function __invoke(RegistrationCommand $command): Account
    {
        $encodedPassword = $this->passwordEncoder->encode($command->password);

        $account = new Account($command->email, $encodedPassword, $command->firstName, $command->lastName);

        $this->accountRepository->add($account);

        $this->eventBus->dispatch(new AccountRegisteredEvent($account));

        return $account;
    }
}
