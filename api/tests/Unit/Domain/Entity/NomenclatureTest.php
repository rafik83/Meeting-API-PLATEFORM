<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Tag;

class NomenclatureTest extends TestCase
{
    public function testAddTag(): void
    {
        $community = $this->prophesize(Community::class);
        $nomenclature = new Nomenclature($community->reveal(), 'My Nomenclature');

        $rootTag = new Tag('My Tag');
        $childTag = new Tag('My Tag');

        $nomenclature->addTag($rootTag);
        $nomenclature->addTag($childTag, $rootTag);

        self::assertCount(2, $nomenclature->getTags());

        self::assertEquals($rootTag, $nomenclature->getTags()->getValues()[0]->getTag());
        self::assertNull($nomenclature->getTags()->getValues()[0]->getParent());

        self::assertEquals($childTag, $nomenclature->getTags()->getValues()[1]->getTag());
        self::assertNotNull($nomenclature->getTags()->getValues()[1]->getParent());
    }

    public function testRemoveTag(): void
    {
        $community = $this->prophesize(Community::class);
        $nomenclature = new Nomenclature($community->reveal(), 'My Nomenclature');

        $rootTag = new Tag('My Tag');
        $childTag = new Tag('My Tag');

        $nomenclature->addTag($rootTag);
        $nomenclature->addTag($childTag, $rootTag);

        self::assertCount(2, $nomenclature->getTags());

        $nomenclature->removeTag($childTag);

        self::assertCount(1, $nomenclature->getTags());
    }

    public function testRemoveRootTag(): void
    {
        $community = $this->prophesize(Community::class);
        $nomenclature = new Nomenclature($community->reveal(), 'My Nomenclature');

        $rootTag = new Tag('My Tag');
        $childTag = new Tag('My Tag');

        $nomenclature->addTag($rootTag);
        $nomenclature->addTag($childTag, $rootTag);

        self::assertCount(2, $nomenclature->getTags());

        $nomenclature->removeTag($rootTag);

        self::assertCount(0, $nomenclature->getTags());
    }
}
