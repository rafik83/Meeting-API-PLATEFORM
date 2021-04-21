<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Vimeet\Nomenclature;

use PHPUnit\Framework\TestCase;
use Proximum\Vimeet365\Vimeet\Nomenclature\Converter;

class ConverterTest extends TestCase
{
    private const FILES_DIRECTORY = __DIR__ . '/../../files/nomenclatures';

    /**
     * @dataProvider provideTestConvert
     */
    public function testConvert(string $inputFilename, string $expectedFilename): void
    {
        $outputFile = new \SplTempFileObject();

        $converter = new Converter();
        $converter->convert(new \SplFileObject($inputFilename, 'r'), $outputFile);

        ob_start();
        $outputFile->rewind();
        $outputFile->fpassthru();
        $content = ob_get_clean();

        self::assertStringEqualsFile($expectedFilename, $content);
    }

    public function provideTestConvert(): iterable
    {
        yield 'simple' => [
           self::FILES_DIRECTORY . '/input-simple.csv',
           self::FILES_DIRECTORY . '/output-simple.csv',
        ];
        yield 'single-language' => [
           self::FILES_DIRECTORY . '/input-single-language.csv',
           self::FILES_DIRECTORY . '/output-single-language.csv',
        ];
        yield 'multi-language' => [
           self::FILES_DIRECTORY . '/input-multi-language.csv',
           self::FILES_DIRECTORY . '/output-multi-language.csv',
        ];
    }
}
