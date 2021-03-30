<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal;

use Proximum\Vimeet365\Api\Application\Command\Member\MemberGoalCommandInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature\NomenclatureTag;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TagBelongToGoalValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof MemberGoalCommandInterface) {
            throw new UnexpectedTypeException($value, MemberGoalCommandInterface::class);
        }

        if (!$constraint instanceof TagBelongToGoal) {
            throw new UnexpectedTypeException($constraint, TagBelongToGoal::class);
        }

        $community = $value->getMember()->getCommunity();

        /** @var Goal|false $goal */
        $goal = $community->getGoals()->filter(fn (Goal $goal) => $goal->getId() === $value->getGoal())->first();

        if ($goal === false) {
            return;
        }

        foreach ($value->getTags() as $i => $tag) {
            $found = $goal->getNomenclature()->getTags()->exists(fn (int $index, NomenclatureTag $nomenclatureTag): bool => $nomenclatureTag->getTag()->getId() === $tag->id);

            if (!$found) {
                $this->context->buildViolation($constraint->message)
                    ->setInvalidValue($tag)
                    ->setCode(TagBelongToGoal::INVALID_CODE)
                    ->atPath("tags[$i].id")
                    ->addViolation();
            }
        }
    }
}
