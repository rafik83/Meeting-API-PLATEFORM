<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Domain\Entity\Community;
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

        $this->doctrine->flush();
    }
}
