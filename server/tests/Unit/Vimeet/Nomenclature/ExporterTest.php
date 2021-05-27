<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Vimeet\Nomenclature;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Application\Nomenclature\Importer;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureTagRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\TagRepositoryInterface;
use Proximum\Vimeet365\Vimeet\Nomenclature\Exporter;

class ExporterTest extends TestCase
{
    use ProphecyTrait;

    private const FILES_DIRECTORY = __DIR__ . '/../../files/nomenclatures';

    public function testExport(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getNomenclatures()->willReturn(new ArrayCollection());
        $community->getLanguages()->willReturn(['en', 'fr']);

        $nomenclature = new Nomenclature('Nomenclature', $community->reveal());

        $importer = new Importer(
            $this->prophesize(TagRepositoryInterface::class)->reveal(),
            $this->prophesize(NomenclatureTagRepositoryInterface::class)->reveal()
        );

        $importer->import($nomenclature, new \SplFileObject(self::FILES_DIRECTORY . '/output-multi-language.csv'));

        $exporter = new Exporter();
        $outputFile = new \SplTempFileObject();
        $exporter->export($nomenclature, $outputFile);

        ob_start();
        $outputFile->rewind();
        $outputFile->fpassthru();
        $content = ob_get_clean();

        self::assertStringEqualsFile(self::FILES_DIRECTORY . '/export-multi-languages.csv', $content);

        $community->getLanguages()->willReturn(['fr']);

        $exporter = new Exporter();
        $outputFile = new \SplTempFileObject();
        $exporter->export($nomenclature, $outputFile);

        ob_start();
        $outputFile->rewind();
        $outputFile->fpassthru();
        $content = ob_get_clean();

        self::assertStringEqualsFile(self::FILES_DIRECTORY . '/export-single-languages.csv', $content);
    }
}
