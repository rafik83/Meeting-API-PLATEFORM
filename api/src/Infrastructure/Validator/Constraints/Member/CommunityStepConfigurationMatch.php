<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\Member;

use Symfony\Component\Validator\Constraint;

/**
 * Check that the tags match the configuration on step.
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class CommunityStepConfigurationMatch extends Constraint
{
    public const UNKNOWN_TAG_ERROR = '7ac035d4-2492-4f57-9470-945a7e6a08c1';

    public string $unknownTagsMessage = 'The tags "{{ value }}" does not belong to the step';

    public function getTargets(): string
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
