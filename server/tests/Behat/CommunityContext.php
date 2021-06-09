<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Proximum\Vimeet365\Core\Domain\Entity\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Domain\Repository\AccountRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\MemberRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\TagRepositoryInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class CommunityContext implements Context
{
    public function __construct(
        private EntityManagerInterface $doctrine,
        private CommunityRepositoryInterface $communityRepository,
        private MemberRepositoryInterface $memberRepository,
        private AccountRepositoryInterface $accountRepository,
        private TagRepositoryInterface $tagRepository,
        private CompanyRepositoryInterface $companyRepository,
        private NomenclatureRepositoryInterface $nomenclatureRepository,
    ) {
    }

    /**
     * @Given I've selected those tags:
     */
    public function iSelectThoseTags(TableNode $table)
    {
        $member = $this->memberRepository->findOneById(1);
        $community = $this->communityRepository->findOneById(1);

        $buyGoal = $community->getGoals()->filter(
            function (Goal $goal) {
                if ($goal->getTag() === null) {
                    return false;
                } else {
                    return $goal->getTag()->getLabel() === 'Buy';
                }
            }
        )->first();

        foreach ($table as $row) {
            $tag = $this->tagRepository->getOneById((int) $row['tagId']);
            $this->doctrine->persist(new Member\Goal($member, $buyGoal, $tag, null));
        }

        $this->doctrine->flush();
    }

    private function createCommunityCardList($community)
    {
        $cardList = new CardList($community, 'My nice card list', [CardType::get(CardType::MEMBER), CardType::get(CardType::COMPANY)], Sorting::get(Sorting::ALPHABETICAL));
        $cardList->publish();

        $this->doctrine->persist($cardList);
        $this->doctrine->flush();
    }

    /**
     * @Given the aerospace community is created
     */
    public function theAerospaceCommunityIsCreated(string $email = null): void
    {
        $community = new Community('aerospace');
        $this->doctrine->persist($community);
        $this->doctrine->flush();

        $this->createCommunityCardList($community);
    }

    /**
     * @Given As :email I want to join aerospace community
     */
    public function iWantToJoinTheAerospaceCommunity(string $email): void
    {
        $community = $this->communityRepository->findOneById(1);
        $account = $this->accountRepository->findOneByEmail($email);
        if ($account !== null) {
            $member = new Member($community, $account, new DateTimeImmutable());
            $this->doctrine->persist($member);
        }

        $this->doctrine->flush();
    }

    /**
     * @Given these are my main objectives:
     */
    public function theseAreMyMainObjectives(TableNode $table)
    {
        $member = $this->memberRepository->findOneById(1);
        $community = $this->communityRepository->findOneById(1);

        $tags = $community->getMainGoal()->getNomenclature()->getTags()->map(fn (NomenclatureTag $tag): Tag => $tag->getTag());

        $mainGoal = $community->getGoals()[0];
        foreach ($table as $row) {
            $tag = $tags->filter(fn (Tag $tag) => $tag->getLabel('en') === $row['tagName'])->first();

            if (!\is_null($tag) || !$tag) {
                $this->doctrine->persist(new Member\Goal($member, $mainGoal, $tag, null));
            }
        }

        $this->doctrine->flush();
    }

    /**
     * @Given the company :companyName (:domain) has been already registered
     */
    public function theCompanyHasBeenAlreadyRegistered(string $companyName, string $domain)
    {
        $company = new Company($companyName, 'FR', $domain, 'A nice company');
        $company->setHubspotId('2565911836');
        $this->companyRepository->add($company);
        $this->doctrine->flush();
    }
}
