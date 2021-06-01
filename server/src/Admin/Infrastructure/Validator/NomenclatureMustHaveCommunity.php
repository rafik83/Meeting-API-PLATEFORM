<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * The selected nomenclature must belong to the a community
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class NomenclatureMustHaveCommunity extends Constraint
{
    public string $message = 'This nomenclature must belong to a community';
}
