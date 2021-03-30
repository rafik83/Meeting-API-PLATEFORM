<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\MemberGoal;

use Symfony\Component\Validator\Constraint;

/**
 * Validate that we have tags & goals belonging to the member community
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class GoalConfigurationMatch extends Constraint
{
    public const INVALID_GOALS = '2412ae29-2218-493c-9942-659ef0482a91';
    public const INVALID_TAGS = '84feafe3-ac47-4932-a5f1-229d9ca623b6';
    public const PARENT_NOT_CONFIGURED = '3ee827e4-d3e8-4fa2-ad67-c2480e04d5d8';

    public string $goalDoesntBelongToTheCommunityMessage = "The goal doesn't belong to the current community";
    public string $invalidTagsMessage = 'Some tags are not linked to this goal';
    public string $parentNotConfiguredMessage = "Can't edit this goal as the parent goal is not configured";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
