<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Infrastructure\Validator;

use Doctrine\Common\Collections\ArrayCollection;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\NomenclatureMustHaveCommunity;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\NomenclatureMustHaveCommunityValidator;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NomenclatureMustHaveCommunityValidatorTest extends ConstraintValidatorTestCase
{
    use ProphecyTrait;

    protected function createValidator(): NomenclatureMustHaveCommunityValidator
    {
        return new NomenclatureMustHaveCommunityValidator();
    }

    public function testNull(): void
    {
        $this->validator->validate(null, new NomenclatureMustHaveCommunity());

        $this->assertNoViolation();
    }

    public function testNotANomenclature(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(new \stdClass(), new NomenclatureMustHaveCommunity());
    }

    public function testHasACommunity(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getNomenclatures()->willReturn(new ArrayCollection());

        $nomenclature = new Nomenclature('ref', $community->reveal());

        $this->validator->validate($nomenclature, new NomenclatureMustHaveCommunity());

        $this->assertNoViolation();
    }

    public function testDoNotHaveACommunity(): void
    {
        $nomenclature = new Nomenclature('ref', null);

        $this->validator->validate($nomenclature, new NomenclatureMustHaveCommunity());

        self::assertCount(1, $this->context->getViolations());
    }
}
