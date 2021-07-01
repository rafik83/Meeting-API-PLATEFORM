<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Infrastructure\Validator;

use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Dto\Community\Goal\RefinedGoalDto;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\RefinedGoalTagUniqueness;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\RefinedGoalTagUniquenessValidator;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class RefinedGoalTagUniquenessValidatorTest extends ConstraintValidatorTestCase
{
    use ProphecyTrait;

    public function testEmpty(): void
    {
        $this->validator->validate([], new RefinedGoalTagUniqueness());

        $this->assertNoViolation();
    }

    public function testValid(): void
    {
        $mainGoal = $this->prophesize(Goal::class);

        $goalA = new RefinedGoalDto($mainGoal->reveal());
        $tagA = $this->prophesize(Tag::class);
        $tagA->getId()->willReturn(1);
        $goalA->tag = $tagA->reveal();

        $goalB = new RefinedGoalDto($mainGoal->reveal());
        $tagB = $this->prophesize(Tag::class);
        $tagB->getId()->willReturn(2);
        $goalB->tag = $tagB->reveal();

        $this->validator->validate([
            $goalA,
            $goalB,
        ], new RefinedGoalTagUniqueness());

        $this->assertNoViolation();
    }

    public function testInvalid(): void
    {
        $goalA = new RefinedGoalDto($this->prophesize(Goal::class)->reveal());
        $tagA = $this->prophesize(Tag::class);
        $tagA->getId()->willReturn(1);
        $goalA->tag = $tagA->reveal();

        $this->validator->validate([$goalA, $goalA], new RefinedGoalTagUniqueness());

        self::assertCount(2, $this->context->getViolations());
    }

    protected function createValidator(): RefinedGoalTagUniquenessValidator
    {
        return new RefinedGoalTagUniquenessValidator();
    }
}
