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

    private function buildBuyObjectiveTreeTag(Community $community, Tag $nomenclatureTag, Goal $parent)
    {
        /*  The tree belongs to activity_field nomenclature and looks like this
         *
         *                                                              Buy
         *
         *                                                               │
         *                         ┌─────────────────────────────────────┴─────────────────────────────────────────────────────────┐
         *                         ▼                                                                                               ▼
         *                     Satellites                                                                                       Space Apps
         *                         │
         *                  ┌──────┴──────────────────────────────────────┐                                                        │
         *                  ▼                                             ▼                                                 ┌──────┴──────────────────────────────────────┐
         *              SpaceR&D                              EEEComponentsAndQuality                                       ▼                                             ▼
         *                 │                                             │                                              SpaceR&D                              EEEComponentsAndQuality
         *          ┌──────┴─────────────────┐               ┌───────────┴────────────────────────┐                        │                                             │
         *          ▼                        ▼               ▼                                    ▼                 ┌──────┴─────────────────┐               ┌───────────┴─────────┬──
         * Electromagnetics          PowerGenerator         EEE                             Method and Process      └►                       ▼               ▼                     │
         *                                           Components technologies                                       ElectroMagnetics  PowerGenerator         EEE                    ▼
         *                                                                                                                                           Components technologies    Method and Process                                                                                                                                                                                   Method and Process
         */
        $activityFieldNomenclature = new Nomenclature('activity_fields', $community);

        $this->doctrine->persist($activityFieldNomenclature);

        $buyGoal = new Goal($community, $activityFieldNomenclature, $nomenclatureTag, $parent, null, 1, 3);

        // Satellite Branch

        $satelliteTag = new Tag();
        $satelliteTag->setLabel('Satellites');
        $this->doctrine->persist($satelliteTag);

        $activityFieldNomenclature->addTag($satelliteTag);

        $spaceRAndDTag = new Tag();
        $spaceRAndDTag->setLabel('Space R&D');
        $this->doctrine->persist($spaceRAndDTag);
        $activityFieldNomenclature->addTag($spaceRAndDTag, $satelliteTag);

        $EEEComponentsAndQualityTag = new Tag();
        $EEEComponentsAndQualityTag->setLabel('EEE Components And Quality');
        $this->doctrine->persist($EEEComponentsAndQualityTag);
        $activityFieldNomenclature->addTag($EEEComponentsAndQualityTag, $satelliteTag);

        $ElectromagneticTag = new Tag();
        $ElectromagneticTag->setLabel('Electromagnetic');
        $this->doctrine->persist($ElectromagneticTag);
        $activityFieldNomenclature->addTag($ElectromagneticTag, $spaceRAndDTag);

        $PowerGeneratorTag = new Tag();
        $PowerGeneratorTag->setLabel('PowerGenerator');
        $this->doctrine->persist($PowerGeneratorTag);
        $activityFieldNomenclature->addTag($PowerGeneratorTag, $spaceRAndDTag);

        $EEEComponentsAndTechnologyTags = new Tag();
        $EEEComponentsAndTechnologyTags->setLabel('EEE Components technologies');
        $this->doctrine->persist($EEEComponentsAndTechnologyTags);
        $activityFieldNomenclature->addTag($EEEComponentsAndTechnologyTags, $EEEComponentsAndQualityTag);

        $methodAndProcessTag = new Tag();
        $methodAndProcessTag->setLabel('Method and process');
        $this->doctrine->persist($methodAndProcessTag);
        $activityFieldNomenclature->addTag($methodAndProcessTag, $EEEComponentsAndQualityTag);

        // Space App branch Branch

        $spaceAppsTag = new Tag();
        $spaceAppsTag->setLabel('SpaceApps');
        $this->doctrine->persist($spaceAppsTag);

        $activityFieldNomenclature->addTag($spaceAppsTag);

        $spaceRAndDTag = new Tag();
        $spaceRAndDTag->setLabel('SpaceR&D');
        $this->doctrine->persist($spaceRAndDTag);
        $activityFieldNomenclature->addTag($spaceRAndDTag, $spaceAppsTag);

        $EEEComponentsAndQualityTag = new Tag();
        $EEEComponentsAndQualityTag->setLabel('EEEComponentsAndQuality');
        $this->doctrine->persist($EEEComponentsAndQualityTag);
        $activityFieldNomenclature->addTag($EEEComponentsAndQualityTag, $spaceAppsTag);

        $ElectromagneticTag = new Tag();
        $ElectromagneticTag->setLabel('Electromagnetic');
        $this->doctrine->persist($ElectromagneticTag);
        $activityFieldNomenclature->addTag($ElectromagneticTag, $spaceRAndDTag);

        $PowerGeneratorTag = new Tag();
        $PowerGeneratorTag->setLabel('PowerGenerator');
        $this->doctrine->persist($PowerGeneratorTag);
        $activityFieldNomenclature->addTag($PowerGeneratorTag, $spaceRAndDTag);

        $EEEComponentsAndTechnologyTags = new Tag();
        $EEEComponentsAndTechnologyTags->setLabel('EEE Components technologies');
        $this->doctrine->persist($EEEComponentsAndTechnologyTags);
        $activityFieldNomenclature->addTag($EEEComponentsAndTechnologyTags, $EEEComponentsAndQualityTag);

        $methodAndProcessTag = new Tag();
        $methodAndProcessTag->setLabel('Method and process');
        $this->doctrine->persist($methodAndProcessTag);
        $activityFieldNomenclature->addTag($methodAndProcessTag, $EEEComponentsAndQualityTag);

        $this->doctrine->persist($activityFieldNomenclature);
        $this->doctrine->persist($buyGoal);

        $this->doctrine->flush();
    }

    private function createCommunityGoalNomenclature(Community $community)
    {
        /*
            The community has 3 main goals : buy, sell and find industrial partners
        */
        $goalNomenclature = new Nomenclature('goal_and_objectives');

        $buyTag = new Tag();
        $buyTag->setLabel('Buy');

        $sellTag = new Tag();
        $sellTag->setLabel('Sell!');

        $this->doctrine->persist($buyTag);
        $this->doctrine->persist($sellTag);

        $goalNomenclature->addTag($buyTag);
        $goalNomenclature->addTag($sellTag);

        $this->doctrine->persist($goalNomenclature);

        $goal1 = new Goal($community, $goalNomenclature, null, null, null, 1, 2);
        $this->doctrine->persist($goal1);
        $this->doctrine->flush();

        $this->buildBuyObjectiveTreeTag($community, $buyTag, $goal1);
    }

    private function registerMember(string $email, Community $community)
    {
        $account = $this->accountRepository->findOneByEmail($email);
        if ($account !== null) {
            $member = new Member($community, $account, new DateTimeImmutable());
            $this->doctrine->persist($member);
        }

        $this->doctrine->flush();
    }

    /**
     * @Given I've selected those tags:
     */
    public function iSelectThoseTags(TableNode $table)
    {
        $member = $this->memberRepository->findOneById(1);
        $community = $this->communityRepository->findOneById(1);

        $buyGoal = $community->getGoals()->filter(function (Goal $goal) {
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
