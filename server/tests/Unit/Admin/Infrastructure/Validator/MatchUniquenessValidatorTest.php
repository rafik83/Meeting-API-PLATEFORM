<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Infrastructure\Validator;

use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Dto\Community\Goal\MatchingGoalDto;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\GoalMatching\MatchUniqueness;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\GoalMatching\MatchUniquenessValidator;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class MatchUniquenessValidatorTest extends ConstraintValidatorTestCase
{
    use ProphecyTrait;

    public function testNotIterable(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(null, new MatchUniqueness());
    }

    public function testEmpty(): void
    {
        $this->validator->validate([], new MatchUniqueness());

        $this->assertNoViolation();
    }

    public function testValid(): void
    {
        $goal = $this->prophesize(Goal::class);
        $tagA = $this->prophesize(Tag::class);
        $tagA->getId()->willReturn(1);
        $tagB = $this->prophesize(Tag::class);
        $tagB->getId()->willReturn(2);

        $values = [
            new MatchingGoalDto(
                $goal->reveal(),
                $tagA->reveal(),
                $tagB->reveal()
            ),
            new MatchingGoalDto(
                $goal->reveal(),
                $tagB->reveal(),
                $tagA->reveal()
            ),
        ];

        $this->validator->validate($values, new MatchUniqueness());

        $this->assertNoViolation();
    }

    public function testInvalid(): void
    {
        $goal = $this->prophesize(Goal::class);
        $tagA = $this->prophesize(Tag::class);
        $tagA->getId()->willReturn(1);
        $tagB = $this->prophesize(Tag::class);
        $tagB->getId()->willReturn(2);

        $values = [
            new MatchingGoalDto(
                $goal->reveal(),
                $tagA->reveal(),
                $tagB->reveal()
            ),
            new MatchingGoalDto(
                $goal->reveal(),
                $tagA->reveal(),
                $tagB->reveal()
            ),
        ];

        $this->validator->validate($values, new MatchUniqueness());

        self::assertCount(1, $this->context->getViolations());
    }

    protected function createValidator(): MatchUniquenessValidator
    {
        return new MatchUniquenessValidator();
    }
}
