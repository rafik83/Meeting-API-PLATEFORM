<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Validator\GoalMatching;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MatchUniquenessValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!\is_array($value) && !$value instanceof \Traversable) {
            throw new UnexpectedTypeException($value, 'iterable');
        }

        if (!$constraint instanceof MatchUniqueness) {
            throw new UnexpectedTypeException($constraint, MatchUniqueness::class);
        }

        $existing = [];
        foreach ($value as $i => $matchingTag) {
            \assert($matchingTag->from !== null);
            \assert($matchingTag->to !== null);

            $hash = [$matchingTag->from->getId(), $matchingTag->to->getId()];

            if (\in_array($hash, $existing, true)) {
                $this->context
                    ->buildViolation($constraint->message)
                    ->atPath("[$i].to")
                    ->addViolation();
            }

            $existing[] = $hash;
        }
    }
}
