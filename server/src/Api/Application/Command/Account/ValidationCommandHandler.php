<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account;

use Proximum\Vimeet365\Core\Application\Mail\AccountValidationMailerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Security\AccountValidationTokenStorageInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ValidationCommandHandler
{
    public function __construct(
        private AccountValidationTokenStorageInterface $tokenStorage,
        private AccountValidationMailerInterface $mailer
    ) {
    }

    public function __invoke(ValidationCommand $command): Account
    {
        $account = $command->account;
        $token = $this->tokenStorage->generateToken($account);

        $origin = $command->origin;

        if (\is_null($origin)) {
            throw new BadRequestException('Please provide a valid origin header');
        }

        $this->mailer->send($account, $token, $origin);

        return $account;
    }
}
