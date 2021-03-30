<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal;

use Symfony\Component\Validator\Constraint;

/**
 * Validate that the chosen tags belong to the goal
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class TagBelongToGoal extends Constraint
{
    public const INVALID_CODE = '4f0b294d-9ee4-4777-90e4-42b4192b2713';

    public string $message = 'The tag does not belong to the chosen goal';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
