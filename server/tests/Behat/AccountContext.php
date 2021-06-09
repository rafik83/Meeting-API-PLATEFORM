<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Repository\AccountRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureRepositoryInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class AccountContext implements Context
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private NomenclatureRepositoryInterface $nomenclatureRepository,
        private EntityManagerInterface $doctrine,
        private CommunityRepositoryInterface $communityRepository,
        private CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * @Given the user :email is created
     */
    public function create(string $email)
    {
        $company = $this->companyRepository->findOneByDomain('vimeet.events');

        $account = new Account($email, 'password', 'John', 'Doe', null, ['FR', 'EN']);

        if (!\is_null($company)) {
            $account->setCompany($company);
        }
        $this->doctrine->persist($account);
    }
}
