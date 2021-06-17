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
    public const INVALID_ERROR = '115f57e0-4219-4eaf-93d8-3bba8f2b5d3a';

    public string $message = "Le tag n'appartient pas a la nomenclature";

    public string $nomenclaturePropertyPath = 'nomenclature';
}
