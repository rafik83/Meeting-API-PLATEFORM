<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command;

use Proximum\Vimeet365\Application\Adapter\PasswordEncoderInterface;
use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Domain\Repository\AccountRepositoryInterface;

class AccountRegistrationCommandHandler
{
    private AccountRepositoryInterface $accountRepository;
    private PasswordEncoderInterface $passwordEncoder;

    public function __construct(AccountRepositoryInterface $accountRepository, PasswordEncoderInterface $passwordEncoder)
    {
        $this->accountRepository = $accountRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(AccountRegistrationCommand $command): Account
    {
        $encodedPassword = $this->passwordEncoder->encode($command->password);

        $account = new Account($command->email, $encodedPassword, $command->firstName, $command->lastName);

        $this->accountRepository->add($account);

        return $account;
    }
}
