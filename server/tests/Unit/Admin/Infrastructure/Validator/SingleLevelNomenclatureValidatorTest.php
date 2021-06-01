<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Infrastructure\Validator;

use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\SingleLevelNomenclature;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\SingleLevelNomenclatureValidator;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class SingleLevelNomenclatureValidatorTest extends ConstraintValidatorTestCase
{
    use ProphecyTrait;

    public function testNullValue(): void
    {
        $this->validator->validate(null, new SingleLevelNomenclature());

        $this->assertNoViolation();
    }

    public function testHasSingleLevel(): void
    {
        $nomenclature = new Nomenclature('test');
        $nomenclature->addTag(new Tag('tag'));

        $this->validator->validate($nomenclature, new SingleLevelNomenclature());

        $this->assertNoViolation();
    }

    public function testHasNotASingleLevel(): void
    {
        $nomenclature = new Nomenclature('test');
        $tag = new Tag('tag');
        $parentTag = new Tag('tag');
        $nomenclature->addTag($parentTag);
        $nomenclature->addTag($tag, $parentTag);

        $this->validator->validate($nomenclature, new SingleLevelNomenclature());

        self::assertCount(1, $this->context->getViolations());
    }

    protected function createValidator(): SingleLevelNomenclatureValidator
    {
        return new SingleLevelNomenclatureValidator();
    }
}
