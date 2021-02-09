<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\Member;

use Symfony\Component\Validator\Constraint;

/**
 * Check that the step belong to the community of the member.
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class CommunityStepExist extends Constraint
{
    public const INVALID_STEP_ERROR = '7a4cc493-8349-4847-8792-54af256aa97e';

    public string $message = 'The step {{ value }} does not belong to the member community';

    public function getTargets(): string
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
