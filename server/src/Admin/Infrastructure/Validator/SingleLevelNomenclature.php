<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Check that the nomenclature only have 1 level of values
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class SingleLevelNomenclature extends Constraint
{
    public string $message = 'This nomenclature must only have 1 level of tags';
}
