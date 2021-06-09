<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Entity\Member;
use Proximum\Vimeet365\Core\Domain\Repository\AccountRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureRepositoryInterface;

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

    /**
     * @Given those accounts are created
     */
    public function crateUsers(TableNode $accounts)
    {
        $community = $this->communityRepository->findOneById(1);

        $JobPosition = $this->nomenclatureRepository
                            ->findJobPositionNomenclature()
                            ->getTags()
                            ->first()
                            ->getTag();

        foreach ($accounts as $accountRow) {
            $account = new Account($accountRow['email'], 'password', $accountRow['firstName'], $accountRow['lastName'], null, ['FR', 'EN'], $JobPosition);

            $company = $this->companyRepository->findOneByDomain($accountRow['companyDomainName']);

            if (!\is_null($company)) {
                $account->setCompany($company);
            }

            $member = new Member($community, $account, new DateTimeImmutable());
            $this->doctrine->persist($member);
            $this->doctrine->persist($account);
        }

        $this->doctrine->flush();
    }
}
