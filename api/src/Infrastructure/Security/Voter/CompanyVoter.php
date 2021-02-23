<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Security\Voter;

use Proximum\Vimeet365\Domain\Entity\Company;
use Proximum\Vimeet365\Infrastructure\Security\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CompanyVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof Company && $attribute === 'OWNER';
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if (!$this->supports($attribute, $subject)) {
            throw new \InvalidArgumentException();
        }
        /** @var User $user */
        $user = $token->getUser();

        $account = $user->getAccount();

        return $account->getCompany() !== null && $subject->getId() === $account->getCompany()->getId();
    }
}
