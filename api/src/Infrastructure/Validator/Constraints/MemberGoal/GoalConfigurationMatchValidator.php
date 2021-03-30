<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\MemberGoal;

use Proximum\Vimeet365\Application\Command\Member\SetGoalsCommand;
use Proximum\Vimeet365\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class GoalConfigurationMatchValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof SetGoalsCommand) {
            throw new UnexpectedTypeException($value, SetGoalsCommand::class);
        }

        if (!$constraint instanceof GoalConfigurationMatch) {
            throw new UnexpectedTypeException($constraint, GoalConfigurationMatch::class);
        }

        $community = $value->member->getCommunity();

        /** @var Goal|false $goal */
        $goal = $community->getGoals()->filter(fn (Goal $goal) => $goal->getId() === $value->goal)->first();

        if ($goal === false) {
            // goal not found in the member community;
            $this->context->buildViolation($constraint->goalDoesntBelongToTheCommunityMessage)
                ->setCode(GoalConfigurationMatch::INVALID_GOALS)
                ->atPath('goal')
                ->addViolation()
            ;

            return;
        }

        if ($goal->getParent() !== null && $goal->getTag() !== null && !$value->member->hasGoal($goal->getParent(), $goal->getTag())) {
            $this->context->buildViolation($constraint->parentNotConfiguredMessage)
                    ->setCode(GoalConfigurationMatch::PARENT_NOT_CONFIGURED)
                    ->atPath('goal')
                    ->addViolation()
                ;

            return;
        }

        $context = $this->context;
        $validator = $context->getValidator()->inContext($context);
        $validator
            ->atPath('tags')
            ->validate($value->tags, new Count(null, $goal->getMin(), $goal->getMax()))
        ;

        $tagsId = array_map(fn (TagDto $tagDto): int => $tagDto->id, $value->tags);

        $foundTags = $goal->getNomenclature()->getTags()
            ->map(fn (NomenclatureTag $nomenclatureTag): int => (int) $nomenclatureTag->getTag()->getId())
            ->filter(fn (int $tagId): bool => \in_array($tagId, $tagsId, true))
            ->getValues()
        ;

        $invalidTags = array_diff($tagsId, $foundTags);

        if (\count($invalidTags) !== 0) {
            $this->context->buildViolation($constraint->invalidTagsMessage)
                ->setInvalidValue($invalidTags)
                ->setCode(GoalConfigurationMatch::INVALID_TAGS)
                ->atPath('tags')
                ->addViolation()
            ;
        }
    }
}
