<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Controller;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Proximum\Vimeet365\Application\Adapter\CommandBusInterface;
use Proximum\Vimeet365\Application\Command\Account\Company\CreateCommand;
use Proximum\Vimeet365\Application\Command\Account\Company\LinkCommand;
use Proximum\Vimeet365\Application\Command\Account\Company\UpdateCommand;
use Proximum\Vimeet365\Application\Command\Account\UpdateProfileCommand;
use Proximum\Vimeet365\Application\Command\Account\UploadAvatarCommand;
use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Infrastructure\Security\User;
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
        /** @var User $user */
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
}
