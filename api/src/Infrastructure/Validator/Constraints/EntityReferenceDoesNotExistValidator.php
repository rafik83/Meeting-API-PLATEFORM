<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EntityReferenceDoesNotExistValidator extends ConstraintValidator
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     *
     * @param EntityReferenceDoesNotExist|Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        \assert($constraint instanceof EntityReferenceDoesNotExist);

        if ($value === null) {
            // noop
            return;
        }

        $objectManager = $this->registry->getManagerForClass($constraint->entity);
        \assert($objectManager !== null);

        $repository = $objectManager->getRepository($constraint->entity);

        $repositoryMethod = $constraint->repositoryMethod;

        $object = $repositoryMethod !== null
            ? $repository->{$repositoryMethod}($value)
            : $repository->findOneBy([$constraint->identityField => $value])
        ;

        if ($constraint->currentField !== null) {
            $context = $this->context->getObject();

            \assert($context !== null);

            $current = PropertyAccess::createPropertyAccessor()->getValue($context, $constraint->currentField);
            if ($current === $object) {
                return;
            }
        }

        if ($object !== null) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode($constraint->code ?? EntityReferenceDoesNotExist::REF_DOES_NOT_EXIST)
                ->addViolation();
        }
    }
}
