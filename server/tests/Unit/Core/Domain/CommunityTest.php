<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Domain;

use PHPUnit\Framework\TestCase;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;

class CommunityTest extends TestCase
{
    /**
     * @dataProvider provideTestIsEventFeatureAvailable
     */
    public function testIsEventFeatureAvailable(bool $expectedResult, ?Nomenclature $skillNomenclature, ?Nomenclature $eventNomenclature): void
    {
        $community = new Community('Community');
        $community->update($community->getName(), 'en', ['en', 'fr'], $skillNomenclature, $eventNomenclature);

        self::assertEquals($expectedResult, $community->isEventFeatureAvailable());
    }

    public function provideTestIsEventFeatureAvailable(): iterable
    {
        $nomenclature = $this->createMock(Nomenclature::class);

        yield [false, null, null];
        yield [false, null, $nomenclature];
        yield [false, $nomenclature, null];
        yield [true, $nomenclature, $nomenclature];
    }
}
