<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Validator;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TagBelongToNomenclatureValidator extends ConstraintValidator
{
    private PropertyAccessorInterface $propertyAccessor;

    public function __construct(PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($value === null) {
            return;
        }

        if (!$value instanceof Tag) {
            throw new UnexpectedTypeException($value, Tag::class);
        }

        if (!$constraint instanceof TagBelongToNomenclature) {
            throw new UnexpectedTypeException($constraint, TagBelongToNomenclature::class);
        }

        if ($this->context->getObject() === null) {
            throw new \RuntimeException('validator must be set on an object property');
        }

        /** @var Nomenclature $nomenclature */
        $nomenclature = $this->propertyAccessor->getValue($this->context->getObject(), $constraint->nomenclaturePropertyPath);

        if ($nomenclature->hasTag($value)) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->setCode(TagBelongToNomenclature::INVALID_ERROR)
            ->addViolation()
        ;
    }
}
