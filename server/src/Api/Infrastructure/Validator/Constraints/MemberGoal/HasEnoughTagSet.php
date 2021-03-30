<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal;

use Symfony\Component\Validator\Constraint;

/**
 * Validate that we have enough tags according to the chosen goal
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class HasEnoughTagSet extends Constraint
{
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
