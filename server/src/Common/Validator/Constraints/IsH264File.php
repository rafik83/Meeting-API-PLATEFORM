<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Common\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class IsH264File extends Constraint
{
    public const INVALID_ERROR = '9136cf77-4077-40fa-b702-960bdb3729e9';

    public string $message = 'invalid codec found {{ invalid }}';
}
