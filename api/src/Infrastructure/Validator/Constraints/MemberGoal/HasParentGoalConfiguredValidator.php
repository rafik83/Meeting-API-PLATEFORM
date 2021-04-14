<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\MemberGoal;

use Proximum\Vimeet365\Application\Command\Member\MemberGoalCommandInterface;
use Proximum\Vimeet365\Domain\Entity\Community\Goal;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class HasParentGoalConfiguredValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof MemberGoalCommandInterface) {
            throw new UnexpectedTypeException($value, MemberGoalCommandInterface::class);
        }

        if (!$constraint instanceof HasParentGoalConfigured) {
            throw new UnexpectedTypeException($constraint, HasParentGoalConfigured::class);
        }

        $member = $value->getMember();
        $community = $member->getCommunity();

        /** @var Goal|false $goal */
        $goal = $community->getGoals()->filter(fn (Goal $goal) => $goal->getId() === $value->getGoal())->first();

        if ($goal === false || $goal->getParent() === null) {
            return;
        }

        if ($goal->getTag() !== null && !$member->hasGoal($goal->getParent(), $goal->getTag())) {
            $this->context->buildViolation($constraint->message)
                ->setCode(HasParentGoalConfigured::INVALID_CODE)
                ->atPath('goal')
                ->addViolation()
            ;

            return;
        }
    }
}
