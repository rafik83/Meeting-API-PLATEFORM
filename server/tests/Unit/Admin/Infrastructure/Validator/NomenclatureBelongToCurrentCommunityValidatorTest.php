<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Infrastructure\Validator;

use Doctrine\Common\Collections\ArrayCollection;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\NomenclatureBelongToCurrentCommunity;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\NomenclatureBelongToCurrentCommunityValidator;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NomenclatureBelongToCurrentCommunityValidatorTest extends ConstraintValidatorTestCase
{
    use ProphecyTrait;

    protected function createValidator(): NomenclatureBelongToCurrentCommunityValidator
    {
        return new NomenclatureBelongToCurrentCommunityValidator(PropertyAccess::createPropertyAccessor());
    }

    public function testNull(): void
    {
        $this->validator->validate(null, new NomenclatureBelongToCurrentCommunity());

        $this->assertNoViolation();
    }

    public function testNotANomenclature(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(new \stdClass(), new NomenclatureBelongToCurrentCommunity());
    }

    public function testHasSameCommunity(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getNomenclatures()->willReturn(new ArrayCollection());
        $community->getId()->willReturn(1);

        $nomenclature = new Nomenclature('ref', $community->reveal());

        $objectToValidate = new \stdClass();
        $objectToValidate->nomenclature = $nomenclature;
        $objectToValidate->community = $community->reveal();

        $this->setObject($objectToValidate);

        $this->validator->validate($nomenclature, new NomenclatureBelongToCurrentCommunity(['communityPropertyPath' => 'community']));

        $this->assertNoViolation();
    }

    public function testHasNotSameCommunity(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getNomenclatures()->willReturn(new ArrayCollection());
        $community->getId()->willReturn(1);

        $otherCommunity = $this->prophesize(Community::class);
        $otherCommunity->getId()->willReturn(2);

        $nomenclature = new Nomenclature('ref', $community->reveal());

        $objectToValidate = new \stdClass();
        $objectToValidate->nomenclature = $nomenclature;
        $objectToValidate->community = $otherCommunity->reveal();

        $this->setObject($objectToValidate);

        $this->validator->validate($nomenclature, new NomenclatureBelongToCurrentCommunity(['communityPropertyPath' => 'community']));

        self::assertCount(1, $this->context->getViolations());
    }
}
