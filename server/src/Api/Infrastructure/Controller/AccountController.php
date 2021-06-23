<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Controller;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Proximum\Vimeet365\Api\Application\Command\Account\CheckValidationTokenCommand;
use Proximum\Vimeet365\Api\Application\Command\Account\Company\CreateCommand;
use Proximum\Vimeet365\Api\Application\Command\Account\Company\LinkCommand;
use Proximum\Vimeet365\Api\Application\Command\Account\Company\UpdateCommand;
use Proximum\Vimeet365\Api\Application\Command\Account\UpdateProfileCommand;
use Proximum\Vimeet365\Api\Application\Command\Account\UploadAvatarCommand;
use Proximum\Vimeet365\Api\Application\Command\Account\ValidationCommand;
use Proximum\Vimeet365\Api\Infrastructure\Security\SymfonyUser;
use Proximum\Vimeet365\Common\Messenger\CommandBusInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\ValidationFailedException;

class AccountController extends AbstractController
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function getMe(): Account
    {
        /** @var SymfonyUser $user */
        $user = $this->getUser();

        return $user->getAccount();
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

    public function uploadAvatar(Request $request, Account $data): Account
    {
        $command = new UploadAvatarCommand($data, $request->files->get('file'));

        try {
            $account = $this->commandBus->handle($command);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }

        return $account;
    }

    public function updateProfile(UpdateProfileCommand $data): Account
    {
        try {
            return $this->commandBus->handle($data);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }
    }

    public function validate(Request $request, Account $data): Account
    {
        try {
            return $this->commandBus->handle(new ValidationCommand($data, $request->headers->get('origin')));
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }
    }

    public function checkValidationToken(CheckValidationTokenCommand $data): Account
    {
        try {
            $account = $this->commandBus->handle($data);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }

        return $account;
    }
}
