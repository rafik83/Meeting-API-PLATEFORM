<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Entity\Community\Step;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
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
    public function iWantToJoinAerospacialCommunity()
    {
        $tagSupplier = new Tag('Supplier');
        $tagBuyer = new Tag('Buyer');
        $community = new Community('aerospacial');
        $nomenclature = new Nomenclature($community, 'Goldfish');
        $nomenclatureTag1 = new NomenclatureTag($nomenclature, $tagSupplier);
        $nomenclatureTag2 = new NomenclatureTag($nomenclature, $tagBuyer);
        $step = new Step($community, $nomenclature, 1, 'I am', null, 1, 1);

        $this->doctrine->persist($tagBuyer);
        $this->doctrine->persist($tagSupplier);
        $this->doctrine->persist($nomenclatureTag1);
        $this->doctrine->persist($nomenclatureTag2);
        $this->doctrine->persist($nomenclature);
        $this->doctrine->persist($step);
        $this->doctrine->persist($community);

        $this->doctrine->flush();
    }

    /**
     * @Given I want to join proximum community
     */
    public function iWantToJoinProximumCommunity()
    {
        $community = new Community('proximum');
        $nomenclature = new Nomenclature($community, 'Goldfish');

        $step1 = new Step($community, $nomenclature, 1, 'I am', null, 1, 1);
        $tagSupplier = new Tag('Supplier');
        $tagBuyer = new Tag('Buyer');

        $nomenclatureTag1 = new NomenclatureTag($nomenclature, $tagSupplier);
        $nomenclatureTag2 = new NomenclatureTag($nomenclature, $tagBuyer);

        $nomenclature2 = new Nomenclature($community, 'Apollo');
        $step2 = new Step($community, $nomenclature2, 2, 'I love', null, 2, 3);
        $tagCaramel = new Tag('Caramel');
        $tagChocolat = new Tag('Chocolat');
        $tagKiwi = new Tag('Kiwi');
        $tagBanane = new Tag('Banane');

        $nomenclatureTag3 = new NomenclatureTag($nomenclature2, $tagCaramel);
        $nomenclatureTag4 = new NomenclatureTag($nomenclature2, $tagChocolat);

        $nomenclatureTag5 = new NomenclatureTag($nomenclature2, $tagKiwi);
        $nomenclatureTag6 = new NomenclatureTag($nomenclature2, $tagBanane);

        $this->doctrine->persist($tagBuyer);
        $this->doctrine->persist($tagSupplier);
        $this->doctrine->persist($nomenclatureTag1);
        $this->doctrine->persist($nomenclatureTag2);
        $this->doctrine->persist($nomenclature);
        $this->doctrine->persist($step1);
        $this->doctrine->persist($step2);
        $this->doctrine->persist($community);

        $this->doctrine->persist($nomenclatureTag3);
        $this->doctrine->persist($nomenclatureTag4);
        $this->doctrine->persist($nomenclatureTag5);
        $this->doctrine->persist($nomenclatureTag6);
        $this->doctrine->persist($nomenclature2);
        $this->doctrine->persist($tagCaramel);
        $this->doctrine->persist($tagChocolat);
        $this->doctrine->persist($tagKiwi);
        $this->doctrine->persist($tagBanane);

        $this->doctrine->flush();
    }
}
