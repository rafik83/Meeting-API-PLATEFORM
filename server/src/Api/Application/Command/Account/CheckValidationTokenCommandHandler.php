<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account;

use Proximum\Vimeet365\Api\Application\Exception\InvalidTokenException;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Security\AccountValidationTokenStorageInterface;

class CheckValidationTokenCommandHandler
{
    public function __construct(
        private AccountValidationTokenStorageInterface $tokenStorage,
    ) {
    }

    public function __invoke(CheckValidationTokenCommand $command): Account
    {
        $account = $command->account;

        if (!$this->tokenStorage->exists($account, $command->token)) {
            throw new InvalidTokenException('Invalid token provided');
        }

        $account->validate();

        return $account;
    }
}
