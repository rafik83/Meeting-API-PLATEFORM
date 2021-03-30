<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal;

use Proximum\Vimeet365\Api\Application\Command\Member\RankGoalsCommand;
use Proximum\Vimeet365\Api\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Core\Domain\Entity\Member\Goal;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TagMustBeSetBeforeRankValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof RankGoalsCommand) {
            throw new UnexpectedTypeException($value, RankGoalsCommand::class);
        }

        if (!$constraint instanceof TagMustBeSetBeforeRank) {
            throw new UnexpectedTypeException($constraint, TagMustBeSetBeforeRank::class);
        }

        $member = $value->getMember();
        $tagsId = $member->getGoals()
            ->filter(fn (Goal $goal): bool => $goal->getCommunityGoal()->getId() === $value->getGoal())
            ->map(fn (Goal $goal) => $goal->getTag()->getId())
            ->getValues();

        /** @var TagDto $tag */
        foreach ($value->getTags() as $i => $tag) {
            if (!\in_array($tag->id, $tagsId, true)) {
                $this->context->buildViolation($constraint->message)
                    ->setInvalidValue($tag)
                    ->setCode(TagMustBeSetBeforeRank::INVALID_CODE)
                    ->atPath("tags[$i].id")
                    ->addViolation();
            }
        }
    }
}
