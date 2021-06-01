<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Validator;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NomenclatureBelongToCurrentCommunityValidator extends ConstraintValidator
{
    private PropertyAccessorInterface $propertyAccessor;

    public function __construct(PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

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

        if (!$constraint instanceof NomenclatureBelongToCurrentCommunity) {
            throw new UnexpectedTypeException($constraint, NomenclatureBelongToCurrentCommunity::class);
        }

        if ($value->getCommunity() === null) {
            return;
        }

        if ($this->context->getObject() === null) {
            throw new \RuntimeException('validator must be set on an object property');
        }

        $community = $this->propertyAccessor->getValue($this->context->getObject(), $constraint->communityPropertyPath);

        if ($community === null) {
            throw new \RuntimeException('a community must be defined on the validated object');
        }

        if ($value->getCommunity()->getId() === $community->getId()) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->atPath('nomenclature')
            ->addViolation()
        ;
    }
}
