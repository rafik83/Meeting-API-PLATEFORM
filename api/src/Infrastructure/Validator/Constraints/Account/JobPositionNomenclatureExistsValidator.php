<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\Account;

use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Domain\Repository\NomenclatureRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class JobPositionNomenclatureExistsValidator extends ConstraintValidator
{
    private NomenclatureRepositoryInterface $nomenclatureRepository;

    public function __construct(NomenclatureRepositoryInterface $nomenclatureRepository)
    {
        $this->nomenclatureRepository = $nomenclatureRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof JobPositionNomenclatureExists) {
            throw new \RuntimeException(sprintf('This validator must be called with %s constraint', JobPositionNomenclatureExists::class));
        }

        if ($value === null) {
            return;
        }

        $nomenclature = $this->nomenclatureRepository->findJobPositionNomenclature();
        if ($nomenclature === null) {
            throw new \RuntimeException('No job position nomenclature found');
        }

        $found = $nomenclature->getTags()->exists(
            fn (int $index, NomenclatureTag $nomenclatureTag): bool => $nomenclatureTag->getTag()->getId() === $value
        );

        if ($found === true) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', (string) $value)
            ->setCode(JobPositionNomenclatureExists::REF_DOES_NOT_EXIST)
            ->addViolation()
        ;
    }
}
