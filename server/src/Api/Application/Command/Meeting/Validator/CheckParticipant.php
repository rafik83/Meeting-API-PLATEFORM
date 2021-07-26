<?php

declare(strict_types=1);

namespace  Proximum\Vimeet365\Api\Application\Command\Meeting\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class CheckParticipant extends Constraint
{
    public $message = 'you would not belong to the list of members!';
}
