<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EntityReferenceExistsValidator extends ConstraintValidator
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     *
     * @param EntityReferenceExists|Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        \assert($constraint instanceof EntityReferenceExists);

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

        if ($object === null) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode($constraint->code ?? EntityReferenceExists::REF_DOES_NOT_EXIST)
                ->addViolation();
        }
    }
}
