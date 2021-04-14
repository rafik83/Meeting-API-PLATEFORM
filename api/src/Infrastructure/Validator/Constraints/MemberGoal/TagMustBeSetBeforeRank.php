<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\MemberGoal;

use Symfony\Component\Validator\Constraint;

/**
 * Validate that we only rank tag that we have on our member goal
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class TagMustBeSetBeforeRank extends Constraint
{
    public const INVALID_CODE = 'ef0d490c-97fa-417c-93d6-5e8635dfa268';

    public string $message = 'The tag is not used in this goal';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
