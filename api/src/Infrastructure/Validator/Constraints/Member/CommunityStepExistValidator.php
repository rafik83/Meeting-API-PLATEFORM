<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints\Member;

use Proximum\Vimeet365\Application\Command\Member\SetCommunityTagCommand;
use Proximum\Vimeet365\Domain\Entity\Community\Step;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CommunityStepExistValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof SetCommunityTagCommand) {
            throw new \RuntimeException(sprintf('This validator must be called with %s value', SetCommunityTagCommand::class));
        }

        if (!$constraint instanceof CommunityStepExist) {
            throw new \RuntimeException(sprintf('This validator must be called with %s constraint', CommunityStepExist::class));
        }

        $community = $value->getMember()->getCommunity();

        $found = $community->getSteps()->exists(fn (int $index, Step $step): bool => $step->getId() === $value->step);

        if ($found === true) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', (string) $value->step)
            ->setCode(CommunityStepExist::INVALID_STEP_ERROR)
            ->atPath('step')
            ->addViolation()
        ;
    }
}
