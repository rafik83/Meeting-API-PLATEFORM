<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Application\Nomenclature;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Proximum\Vimeet365\Application\Nomenclature\Importer;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Repository\NomenclatureTagRepositoryInterface;
use Proximum\Vimeet365\Domain\Repository\TagRepositoryInterface;

class ImporterTest extends TestCase
{
    public function testImportSimple(): void
    {
        $tagRepository = $this->prophesize(TagRepositoryInterface::class);
        $tagNomenclatureRepository = $this->prophesize(NomenclatureTagRepositoryInterface::class);
        $community = $this->prophesize(Community::class);
        $community->getNomenclatures()->willReturn(new ArrayCollection());
        $nomenclature = new Nomenclature($community->reveal(), 'Simple');

        $importer = new Importer($tagRepository->reveal(), $tagNomenclatureRepository->reveal());
        $importer->import($nomenclature, new \SplFileObject(__DIR__ . '/files/simple.csv'));

        self::assertCount(2, $nomenclature->getTags());
        self::assertCount(2, $nomenclature->getRootTags());

        /** @var Nomenclature\NomenclatureTag $firstTag */
        $firstTag = $nomenclature->getTags()->get(0);
        self::assertEquals('1', $firstTag->getExternalId());
        self::assertEquals('1', $firstTag->getLabel());

        /** @var Nomenclature\NomenclatureTag $secondTagTag */
        $secondTag = $nomenclature->getTags()->get(1);
        self::assertEquals('2', $secondTag->getExternalId());
        self::assertEquals('2', $secondTag->getLabel());
    }

    public function testImportComplex(): void
    {
        $tagRepository = $this->prophesize(TagRepositoryInterface::class);
        $tagNomenclatureRepository = $this->prophesize(NomenclatureTagRepositoryInterface::class);
        $community = $this->prophesize(Community::class);
        $community->getNomenclatures()->willReturn(new ArrayCollection());
        $nomenclature = new Nomenclature($community->reveal(), 'Simple');

        $importer = new Importer($tagRepository->reveal(), $tagNomenclatureRepository->reveal());
        $importer->import($nomenclature, new \SplFileObject(__DIR__ . '/files/complex.csv'));

        self::assertCount(2, $nomenclature->getTags());
        self::assertCount(2, $nomenclature->getRootTags());

        /** @var Nomenclature\NomenclatureTag $firstTag */
        $firstTag = $nomenclature->getTags()->get(0);
        self::assertNotEquals(null, $firstTag->getExternalId());
        self::assertEquals('1', $firstTag->getLabel());

        /** @var Nomenclature\NomenclatureTag $secondTagTag */
        $secondTag = $nomenclature->getTags()->get(1);
        self::assertNotEquals(null, $secondTag->getExternalId());
        self::assertEquals('2', $secondTag->getLabel());
    }

    public function testImportMulti(): void
    {
        $tagRepository = $this->prophesize(TagRepositoryInterface::class);
        $tagNomenclatureRepository = $this->prophesize(NomenclatureTagRepositoryInterface::class);
        $community = $this->prophesize(Community::class);
        $community->getNomenclatures()->willReturn(new ArrayCollection());
        $nomenclature = new Nomenclature($community->reveal(), 'Simple');

        $importer = new Importer($tagRepository->reveal(), $tagNomenclatureRepository->reveal());
        $importer->import($nomenclature, new \SplFileObject(__DIR__ . '/files/multi.csv'));

        self::assertCount(6, $nomenclature->getTags());
        self::assertCount(2, $nomenclature->getRootTags());

        /** @var Nomenclature\NomenclatureTag $tag */
        $tag = $nomenclature->getTags()->get(0);
        self::assertEquals('1', $tag->getLabel('en'));
        self::assertEquals('fr1', $tag->getLabel('fr'));
        self::assertNull($tag->getParent());

        /** @var Nomenclature\NomenclatureTag $tag */
        $tag = $nomenclature->getTags()->get(1);
        self::assertEquals('2', $tag->getLabel('en'));
        self::assertEquals('fr2', $tag->getLabel('fr'));
        self::assertNull($tag->getParent());

        $tag = $nomenclature->getTags()->get(2);
        self::assertEquals('1.1', $tag->getLabel('en'));
        self::assertEquals('fr1.1', $tag->getLabel('fr'));
        self::assertNotNull($tag->getParent());
        self::assertEquals('1', $tag->getParent()->getLabel('en'));

        /** @var Nomenclature\NomenclatureTag $tag */
        $tag = $nomenclature->getTags()->get(3);
        self::assertEquals('1.2', $tag->getLabel('en'));
        self::assertEquals('fr1.2', $tag->getLabel('fr'));
        self::assertNotNull($tag->getParent());
        self::assertEquals('1', $tag->getParent()->getLabel('en'));

        $tag = $nomenclature->getTags()->get(4);
        self::assertEquals('2.1', $tag->getLabel('en'));
        self::assertEquals('fr2.1', $tag->getLabel('fr'));
        self::assertNotNull($tag->getParent());
        self::assertEquals('2', $tag->getParent()->getLabel('en'));

        /** @var Nomenclature\NomenclatureTag $tag */
        $tag = $nomenclature->getTags()->get(5);
        self::assertEquals('2.2', $tag->getLabel('en'));
        self::assertEquals('fr2.2', $tag->getLabel('fr'));
        self::assertNotNull($tag->getParent());
        self::assertEquals('2', $tag->getParent()->getLabel('en'));
    }

    public function testImportAlias(): void
    {
        $tagRepository = $this->prophesize(TagRepositoryInterface::class);
        $tagNomenclatureRepository = $this->prophesize(NomenclatureTagRepositoryInterface::class);
        $community = $this->prophesize(Community::class);
        $community->getNomenclatures()->willReturn(new ArrayCollection());
        $nomenclature = new Nomenclature($community->reveal(), 'Simple');

        $importer = new Importer($tagRepository->reveal(), $tagNomenclatureRepository->reveal());
        $importer->import($nomenclature, new \SplFileObject(__DIR__ . '/files/alias.csv'));

        self::assertCount(6, $nomenclature->getTags());
        self::assertCount(2, $nomenclature->getRootTags());

        /** @var Nomenclature\NomenclatureTag $tag */
        $tag = $nomenclature->getTags()->get(0);
        self::assertEquals('1', $tag->getLabel('en'));
        self::assertNull($tag->getParent());

        /** @var Nomenclature\NomenclatureTag $tag */
        $tag = $nomenclature->getTags()->get(1);
        self::assertEquals('2', $tag->getLabel('en'));
        self::assertNull($tag->getParent());

        $tag = $nomenclature->getTags()->get(2);
        self::assertEquals('1.1', $tag->getLabel('en'));
        self::assertNotNull($tag->getParent());
        self::assertEquals('1', $tag->getParent()->getLabel('en'));

        /** @var Nomenclature\NomenclatureTag $tag */
        $tag = $nomenclature->getTags()->get(3);
        self::assertEquals('1.2', $tag->getLabel('en'));
        self::assertNotNull($tag->getParent());
        self::assertEquals('1', $tag->getParent()->getLabel('en'));

        $tag = $nomenclature->getTags()->get(4);
        self::assertEquals('2.1', $tag->getLabel('en'));
        self::assertNotNull($tag->getParent());
        self::assertEquals('2', $tag->getParent()->getLabel('en'));

        /** @var Nomenclature\NomenclatureTag $tag */
        $tag = $nomenclature->getTags()->get(5);
        self::assertEquals('2.2', $tag->getLabel('en'));
        self::assertNotNull($tag->getParent());
        self::assertEquals('2', $tag->getParent()->getLabel('en'));
    }
}
