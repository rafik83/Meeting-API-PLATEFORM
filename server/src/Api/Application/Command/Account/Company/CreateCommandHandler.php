<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account\Company;

use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;

class CreateCommandHandler
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(CreateCommand $command): Account
    {
        $company = new Company($command->name, $command->countryCode, $command->website, $command->activity);

        $command->account->setCompany($company);

        $this->companyRepository->add($company);

        return $command->account;
    }
}
