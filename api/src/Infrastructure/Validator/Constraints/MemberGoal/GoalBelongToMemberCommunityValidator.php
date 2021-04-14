<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\MemberGoal;

use Proximum\Vimeet365\Application\Command\Member\MemberGoalCommandInterface;
use Proximum\Vimeet365\Domain\Entity\Community\Goal;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class GoalBelongToMemberCommunityValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof MemberGoalCommandInterface) {
            throw new UnexpectedTypeException($value, MemberGoalCommandInterface::class);
        }

        if (!$constraint instanceof GoalBelongToMemberCommunity) {
            throw new UnexpectedTypeException($constraint, GoalBelongToMemberCommunity::class);
        }

        $community = $value->getMember()->getCommunity();

        /** @var Goal|false $goal */
        $goal = $community->getGoals()->filter(fn (Goal $goal) => $goal->getId() === $value->getGoal())->first();

        if ($goal !== false) {
            return;
        }

        // goal not found in the member community;
        $this->context->buildViolation($constraint->message)
            ->setCode(GoalBelongToMemberCommunity::INVALID_CODE)
            ->atPath('goal')
            ->addViolation()
        ;
    }
}
