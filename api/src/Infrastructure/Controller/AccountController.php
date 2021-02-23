<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Controller;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Proximum\Vimeet365\Application\Adapter\CommandBusInterface;
use Proximum\Vimeet365\Application\Command\Account\Company\CreateCommand;
use Proximum\Vimeet365\Application\Command\Account\Company\LinkCommand;
use Proximum\Vimeet365\Application\Command\Account\Company\UpdateCommand;
use Proximum\Vimeet365\Domain\Entity\Account;
use Symfony\Component\Messenger\Exception\ValidationFailedException;

class AccountController
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function createCompany(CreateCommand $data): Account
    {
        try {
            $account = $this->commandBus->handle($data);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }

        return $account;
    }

    public function linkCompany(LinkCommand $data): Account
    {
        try {
            $account = $this->commandBus->handle($data);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }

        return $account;
    }

    public function updateCompany(UpdateCommand $data): Account
    {
        try {
            $account = $this->commandBus->handle($data);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }

        return $account;
    }
}
