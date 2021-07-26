<?php

declare(strict_types=1);

namespace  Proximum\Vimeet365\Api\Application\Command\Meeting\Validator;

use Proximum\Vimeet365\Core\Infrastructure\Repository\MemberRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckParticipantValidator extends ConstraintValidator
{
    private MemberRepository $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function validate($value, Constraint $constraint)
    {
         $memberTo = $this->memberRepository->findOneById($value);
 
         if ($memberTo == null) {
            return;
         }
 
          $this->context->buildViolation($constraint->message)
            ->addViolation();
  
    }
}
