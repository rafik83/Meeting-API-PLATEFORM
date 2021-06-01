<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Validator;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NomenclatureMustHaveCommunityValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        if ($value === null) {
            return;
        }

        if (!$value instanceof Nomenclature) {
            throw new UnexpectedTypeException($value, Nomenclature::class);
        }

        if (!$constraint instanceof NomenclatureMustHaveCommunity) {
            throw new UnexpectedTypeException($constraint, NomenclatureMustHaveCommunity::class);
        }

        if ($value->getCommunity() !== null) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->addViolation()
        ;
    }
}
