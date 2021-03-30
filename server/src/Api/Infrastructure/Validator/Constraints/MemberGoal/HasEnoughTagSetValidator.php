<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal;

use Proximum\Vimeet365\Api\Application\Command\Member\MemberGoalCommandInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class HasEnoughTagSetValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof MemberGoalCommandInterface) {
            throw new UnexpectedTypeException($value, MemberGoalCommandInterface::class);
        }

        if (!$constraint instanceof HasEnoughTagSet) {
            throw new UnexpectedTypeException($constraint, HasEnoughTagSet::class);
        }

        $community = $value->getMember()->getCommunity();

        /** @var Goal|false $goal */
        $goal = $community->getGoals()->filter(fn (Goal $goal) => $goal->getId() === $value->getGoal())->first();

        if ($goal === false) {
            return;
        }

        $context = $this->context;
        $validator = $context->getValidator()->inContext($context);
        $validator
            ->atPath('tags')
            ->validate($value->getTags(), new Count(null, $goal->getMin(), $goal->getMax()))
        ;
    }
}
