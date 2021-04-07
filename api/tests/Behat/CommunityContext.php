<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Tag;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class CommunityContext implements Context
{
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Given I want to join aerospacial community
     */
    public function iWantToJoinAerospacialCommunity(): void
    {
        $community = new Community('aerospacial');

        $nomenclature = new Nomenclature('job_position');

        $job1 = new Tag();
        $job1->setLabel('Ministre');

        $job2 = new Tag();
        $job2->setLabel('Culivateur de champignon');

        $nomenclature->addTag($job1);
        $nomenclature->addTag($job2);

        $this->doctrine->persist($nomenclature);
        $this->doctrine->persist($community);

        $this->doctrine->persist($job1);
        $this->doctrine->persist($job2);

        $goalNomenclature = new Nomenclature('aerospacial_goal_nomenclature');

        $goalTag1 = new Tag();
        $goalTag1->setLabel('Etre le plus grand dresseur pokémon');

        $goalTag2 = new Tag();
        $goalTag2->setLabel('Devenir le maître du monde!');

        $goalTag3 = new Tag();
        $goalTag3->setLabel('Vaincre le covid-19');

        $goalTag4 = new Tag();
        $goalTag4->setLabel('Être heureux!');

        $this->doctrine->persist($goalTag1);
        $this->doctrine->persist($goalTag2);
        $this->doctrine->persist($goalTag3);
        $this->doctrine->persist($goalTag4);

        $goalNomenclature->addTag($goalTag1);
        $goalNomenclature->addTag($goalTag2);
        $goalNomenclature->addTag($goalTag3);
        $goalNomenclature->addTag($goalTag4);

        $this->doctrine->persist($goalNomenclature);

        $goal1 = new Goal($community, $goalNomenclature, null, null, null, 2, 3);
        $this->doctrine->persist($goal1);

        $this->doctrine->flush();
    }
}
