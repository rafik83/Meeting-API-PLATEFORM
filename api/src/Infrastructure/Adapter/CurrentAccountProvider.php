<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Adapter;

use Proximum\Vimeet365\Application\Adapter\CurrentAccountProviderInterface;
use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Infrastructure\Security\User;
use Symfony\Component\Security\Core\Security;

class CurrentAccountProvider implements CurrentAccountProviderInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getAccount(): ?Account
    {
        $user = $this->security->getUser();

        if ($user === null) {
            return null;
        }

        if (!$user instanceof User) {
            throw new \RuntimeException(
                sprintf(
                    'This method can only be called for "%s" user instance, "%s" given',
                    User::class,
                    \get_class($user)
                )
            );
        }

        return $user->getAccount();
    }
}
