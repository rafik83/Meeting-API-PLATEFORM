<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Controller;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Proximum\Vimeet365\Api\Application\Command\Company\UploadLogoCommand;
use Proximum\Vimeet365\Common\Messenger\CommandBusInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\ValidationFailedException;

class CompanyController
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function uploadLogo(Request $request, Company $data): Company
    {
        $command = new UploadLogoCommand($data, $request->files->get('logo'));

        try {
            $account = $this->commandBus->handle($command);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }

        return $account;
    }
}
