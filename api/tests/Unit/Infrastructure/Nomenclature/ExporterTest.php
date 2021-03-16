<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Infrastructure\Nomenclature;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Proximum\Vimeet365\Application\Nomenclature\Importer;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Repository\NomenclatureTagRepositoryInterface;
use Proximum\Vimeet365\Domain\Repository\TagRepositoryInterface;
use Proximum\Vimeet365\Infrastructure\Nomenclature\Exporter;

class ExporterTest extends TestCase
{
    private const FILES_DIRECTORY = __DIR__ . '/../../files/nomenclatures';

    public function testExport(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getNomenclatures()->willReturn(new ArrayCollection());
        $community->getLanguages()->willReturn(['fr', 'en']);

        $nomenclature = new Nomenclature('Nomenclature', $community->reveal());

        $importer = new Importer(
            $this->prophesize(TagRepositoryInterface::class)->reveal(),
            $this->prophesize(NomenclatureTagRepositoryInterface::class)->reveal()
        );

        $importer->import($nomenclature, new \SplFileObject(self::FILES_DIRECTORY . '/output-multi-language.csv'));

        $exporter = new Exporter(['fr', 'en', 'it']);
        $outputFile = new \SplTempFileObject();
        $exporter->export($nomenclature, $outputFile);

        ob_start();
        $outputFile->rewind();
        $outputFile->fpassthru();
        $content = ob_get_clean();

        self::assertStringEqualsFile(self::FILES_DIRECTORY . '/output-multi-language.csv', $content);
    }
}
