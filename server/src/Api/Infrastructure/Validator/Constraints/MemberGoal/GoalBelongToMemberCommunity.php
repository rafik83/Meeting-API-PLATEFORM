<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal;

use Symfony\Component\Validator\Constraint;

/**
 * Validate that the goal belong to the member community
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class GoalBelongToMemberCommunity extends Constraint
{
    public const INVALID_CODE = '2412ae29-2218-493c-9942-659ef0482a91';

    public string $message = "The goal doesn't belong to the current community";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
