<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * The selected tag must belong to the selected nomenclature
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class TagBelongToNomenclature extends Constraint
{
    public string $message = "Le tag n'appartient pas a la nomenclature";

    public string $nomenclaturePropertyPath = 'nomenclature';
}
