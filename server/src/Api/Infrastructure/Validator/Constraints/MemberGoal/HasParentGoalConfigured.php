<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal;

use Symfony\Component\Validator\Constraint;

/**
 * Validate that the parent goal is configured
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class HasParentGoalConfigured extends Constraint
{
    public const INVALID_CODE = '3ee827e4-d3e8-4fa2-ad67-c2480e04d5d8';

    public string $message = "Can't edit this goal as the parent goal is not configured";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
