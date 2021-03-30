<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Security\Voter;

use Proximum\Vimeet365\Api\Infrastructure\Security\SymfonyUser;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AccountVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof Account && $attribute === 'OWNER';
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if (!$this->supports($attribute, $subject)) {
            throw new \InvalidArgumentException();
        }
        /** @var SymfonyUser $user */
        $user = $token->getUser();

        $account = $user->getAccount();

        return $subject->getId() === $account->getId();
    }
}
