<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account\Company;

use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;

class LinkCommandHandler
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(LinkCommand $command): Account
    {
        $account = $command->account;

        $company = $this->companyRepository->findOneById($command->company);
        if ($company === null) {
            throw new \RuntimeException(sprintf('Unable to find the company %d', $command->company));
        }

        $account->setCompany($company);

        return $account;
    }
}
