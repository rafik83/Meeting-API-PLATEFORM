<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

class NomenclatureTest extends TestCase
{
    public function testAddTag(): void
    {
        $nomenclature = new Nomenclature('My Nomenclature');

        $rootTag = new Tag(null, 'My Tag');
        $childTag = new Tag(null, 'My Child Tag');

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
        $nomenclature = new Nomenclature('My Nomenclature');

        $rootTag = new Tag(null, 'My Tag');
        $childTag = new Tag(null, 'My Child Tag');

        $nomenclature->addTag($rootTag);
        $nomenclature->addTag($childTag, $rootTag);

        self::assertCount(2, $nomenclature->getTags());

        $nomenclature->removeTag($childTag);

        self::assertCount(1, $nomenclature->getTags());
    }

    public function testRemoveRootTag(): void
    {
        $nomenclature = new Nomenclature('My Nomenclature');

        $rootTag = new Tag(null, 'My Tag');
        $childTag = new Tag(null, 'My Child Tag');

        $nomenclature->addTag($rootTag);
        $nomenclature->addTag($childTag, $rootTag);

        self::assertCount(2, $nomenclature->getTags());

        $nomenclature->removeTag($rootTag);

        self::assertCount(0, $nomenclature->getTags());
    }
}
