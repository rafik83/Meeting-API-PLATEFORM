<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Entity\Community\Step;
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
        $tagSupplier = new Tag('Supplier');
        $tagBuyer = new Tag('Buyer');
        $community = new Community('aerospacial');
        $nomenclature = new Nomenclature('Goldfish', $community);
        $nomenclature->addTag($tagSupplier);
        $nomenclature->addTag($tagBuyer);
        $step = new Step($community, $nomenclature, 1, 'I am', null, 1, 1);

        $this->doctrine->persist($nomenclature);
        $this->doctrine->persist($step);
        $this->doctrine->persist($community);

        $this->doctrine->flush();
    }

    /**
     * @Given I want to join proximum community
     */
    public function iWantToJoinProximumCommunity(): void
    {
        $community = new Community('proximum');
        $nomenclature = new Nomenclature('Goldfish', $community);

        $step1 = new Step($community, $nomenclature, 1, 'I am', null, 1, 1);
        $tagSupplier = new Tag('Supplier');
        $tagBuyer = new Tag('Buyer');

        $nomenclature->addTag($tagSupplier);
        $nomenclature->addTag($tagBuyer);

        $nomenclature2 = new Nomenclature('Apollo', $community);
        $step2 = new Step($community, $nomenclature2, 2, 'I love', null, 2, 3);
        $tagCaramel = new Tag('Caramel');
        $tagChocolat = new Tag('Chocolat');
        $tagKiwi = new Tag('Kiwi');
        $tagBanane = new Tag('Banane');

        $nomenclature2->addTag($tagCaramel);
        $nomenclature2->addTag($tagChocolat);
        $nomenclature2->addTag($tagKiwi);
        $nomenclature2->addTag($tagBanane);

        $this->doctrine->persist($nomenclature);
        $this->doctrine->persist($step1);
        $this->doctrine->persist($step2);
        $this->doctrine->persist($community);
        $this->doctrine->persist($nomenclature2);

        $this->doctrine->flush();
    }
}
