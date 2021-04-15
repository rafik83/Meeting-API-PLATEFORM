<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Account\Company;

use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Domain\Entity\Company;
use Proximum\Vimeet365\Domain\Repository\CompanyRepositoryInterface;

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
