<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;

class NomenclatureContext implements Context
{
    public function __construct(private EntityManagerInterface $doctrine, private CommunityRepositoryInterface $communityRepository)
    {
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

    /**
     * @Given the job position nomenclature is created
     */
    public function createJobPositionNomenclature()
    {
        $nomenclature = new Nomenclature(Nomenclature::JOB_POSITION_NOMENCLATURE);
        $job1 = new Tag();
        $job1->setLabel('Minister');

        $job2 = new Tag();
        $job2->setLabel('Mushroom grower');

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
            The community has 2 main goals : buy sell
        */
        $goalNomenclature = new Nomenclature(Nomenclature::GOAL_AND_OBJECTIVES_NOMENCLATURE);

        $buyTag = new Tag();
        $buyTag->setLabel('Buy');

        $sellTag = new Tag();
        $sellTag->setLabel('Sell');

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

    /**
     * @Given all the required nomenclature are created for the community :communityName
     */
    public function allTheRequiredNomenclatureAreCreated(string $communityName)
    {
        $community = $this->communityRepository->findOneByName($communityName);
        $this->createJobPositionNomenclature();
        $this->createCommunityGoalNomenclature($community);
    }
}
