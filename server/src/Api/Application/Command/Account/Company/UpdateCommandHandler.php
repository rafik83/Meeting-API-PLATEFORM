<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account\Company;

use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateCommandHandler
{
    public function __invoke(UpdateCommand $command): Account
    {
        $account = $command->account;
        $company = $account->getCompany();

        if ($company === null) {
            // the update only work if the user has an company
            throw new NotFoundHttpException('This account does not have a company');
        }

        $company->update($command->name, $command->countryCode, $command->website, $command->activity);

        return $account;
    }
}
