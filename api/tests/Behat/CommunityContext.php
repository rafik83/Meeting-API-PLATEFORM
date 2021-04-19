<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Domain\Entity\Member;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Tag;
use Proximum\Vimeet365\Domain\Repository\AccountRepositoryInterface;
use Proximum\Vimeet365\Domain\Repository\CommunityRepositoryInterface;
use Proximum\Vimeet365\Domain\Repository\MemberRepositoryInterface;
use Proximum\Vimeet365\Domain\Repository\TagRepositoryInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class CommunityContext implements Context
{
    private EntityManagerInterface $doctrine;
    private MemberRepositoryInterface $memberRepository;
    private AccountRepositoryInterface $accountRepository;
    private CommunityRepositoryInterface $communityRepository;
    private TagRepositoryInterface $tagRepository;

    public function __construct(
        EntityManagerInterface $doctrine,
        CommunityRepositoryInterface $communityRepository,
        MemberRepositoryInterface $memberRepository,
        AccountRepositoryInterface $accountRepository,
        TagRepositoryInterface $tagRepository
        ) {
        $this->doctrine = $doctrine;
        $this->memberRepository = $memberRepository;
        $this->accountRepository = $accountRepository;
        $this->communityRepository = $communityRepository;
        $this->tagRepository = $tagRepository;
    }

    private function createJobPositionNomenclature()
    {
        $nomenclature = new Nomenclature('job_position');
        $job1 = new Tag();
        $job1->setLabel('Ministre');

        $job2 = new Tag();
        $job2->setLabel('Cultivateur de champignon');

        $nomenclature->addTag($job1);
        $nomenclature->addTag($job2);

        $this->doctrine->persist($nomenclature);
        $this->doctrine->persist($job1);
        $this->doctrine->persist($job2);
        $this->doctrine->flush();
    }

    private function createCommunityGoalNomenclature(Community $community)
    {
        /*
            The community has 3 main goals : buy, sell and find industrial partners
        */
        $goalNomenclature = new Nomenclature('aerospacial_goal_nomenclature');

        $buyTag = new Tag();
        $buyTag->setLabel('Buy');
        $goalNomenclature->addTag($buyTag);
        $this->doctrine->persist($buyTag);

        $sellTag = new Tag();
        $sellTag->setLabel('Sell');
        $goalNomenclature->addTag($sellTag);
        $this->doctrine->persist($sellTag);

        $findIndustrialPartner = new Tag();
        $findIndustrialPartner->setLabel('Find Industrial Partner');

        $this->doctrine->persist($findIndustrialPartner);
        $goalNomenclature->addTag($findIndustrialPartner);

        $this->doctrine->persist($goalNomenclature);

        $goal1 = new Goal($community, $goalNomenclature, null, null, null, 1, 2);
        $this->doctrine->persist($goal1);

        $this->doctrine->flush();
    }

    private function registerMember(string $email, Community $community)
    {
        $account = $this->accountRepository->findOneByEmail($email);
        if ($account !== null) {
            $member = new Member($community, $account, new DateTimeImmutable());
            $this->doctrine->persist($member);
        }
    }

    /**
     * @Given I want to join aerospacial community
     * @Given As :email I want to join aerospacial community
     */
    public function iWantToJoinAerospacialCommunity(string $email = null): void
    {
        $community = new Community('aerospacial');
        $this->doctrine->persist($community);

        $this->createJobPositionNomenclature();
        $this->createCommunityGoalNomenclature($community);

        $this->doctrine->flush();

        if ($email) {
            $this->registerMember($email, $community);
        }
    }

    /**
     * @Given these are my main objectives:
     */
    public function theseAreMyMainObjectives(TableNode $table)
    {
        $member = $this->memberRepository->findOneById(1);
        $community = $this->communityRepository->findOneById(1);

        $mainGoal = $community->getGoals()[0];
        foreach ($table as $row) {
            $tag = $this->tagRepository->getOneById((int) $row['tagId']);
            $this->doctrine->persist(new Member\Goal($member, $mainGoal, $tag, null));
        }

        $this->doctrine->flush();
    }
}
