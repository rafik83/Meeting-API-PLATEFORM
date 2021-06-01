<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * The selected nomenclature must belong to the current community
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class RefinedGoalTagUniqueness extends Constraint
{
    public string $message = 'Cette valeur est déjà utilisée';
}
