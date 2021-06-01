<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Infrastructure\Validator;

use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\TagBelongToNomenclature;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\TagBelongToNomenclatureValidator;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class TagBelongToNomenclatureValidatorTest extends ConstraintValidatorTestCase
{
    use ProphecyTrait;

    public function testNull(): void
    {
        $this->validator->validate(null, new TagBelongToNomenclature());

        $this->assertNoViolation();
    }

    public function testNotATag(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(new \stdClass(), new TagBelongToNomenclature());
    }

    public function testBelong(): void
    {
        $tag = $this->prophesize(Tag::class);

        $nomenclature = $this->prophesize(Nomenclature::class);
        $nomenclature->hasTag($tag->reveal())->willReturn(true);

        $object = new \stdClass();
        $object->nomenclature = $nomenclature->reveal();

        $this->setObject($object);

        $this->validator->validate($tag->reveal(), new TagBelongToNomenclature());
        $this->assertNoViolation();
    }

    public function testNotBelong(): void
    {
        $tag = $this->prophesize(Tag::class);

        $nomenclature = $this->prophesize(Nomenclature::class);
        $nomenclature->hasTag($tag->reveal())->willReturn(false);

        $object = new \stdClass();
        $object->nomenclature = $nomenclature->reveal();

        $this->setObject($object);

        $this->validator->validate($tag->reveal(), new TagBelongToNomenclature());

        self::assertCount(1, $this->context->getViolations());
    }

    protected function createValidator(): TagBelongToNomenclatureValidator
    {
        return new TagBelongToNomenclatureValidator(PropertyAccess::createPropertyAccessor());
    }
}
