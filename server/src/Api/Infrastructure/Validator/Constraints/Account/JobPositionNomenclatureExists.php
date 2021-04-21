<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\Account;

use Symfony\Component\Validator\Constraint;

/**
 * Check that the tag reference exists & belong to the job position nomenclature
 *
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class JobPositionNomenclatureExists extends Constraint
{
    public const REF_DOES_NOT_EXIST = '0a10ed7e-36f5-4b27-904d-2b5053c35257';

    public string $message = 'The {{ value }} reference does not exist.';
}
