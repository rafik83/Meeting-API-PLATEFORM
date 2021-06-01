<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class RefinedGoalTagUniquenessValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!\is_array($value) && !$value instanceof \Traversable) {
            throw new UnexpectedValueException($value, 'iterable');
        }

        if (!$constraint instanceof RefinedGoalTagUniqueness) {
            throw new UnexpectedValueException($constraint, RefinedGoalTagUniqueness::class);
        }

        $tagIds = [];
        foreach ($value as $index => $item) {
            if ($item->tag === null) {
                continue;
            }

            $tagIds[$index] = $item->tag->getId();
        }

        if (\count(array_unique($tagIds)) === \count($tagIds)) {
            return;
        }

        $invalidTagIds = array_keys(array_filter(array_count_values($tagIds), static fn (int $occurence) => $occurence > 1));
        $invalidIndexes = array_filter($tagIds, static fn (int $id) => \in_array($id, $invalidTagIds, true));

        foreach ($invalidIndexes as $index => $id) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath("[$index].tag")
                ->addViolation()
            ;
        }
    }
}
