<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Security;

use Proximum\Vimeet365\Api\Application\Security\CurrentAccountProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
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

        if (!$user instanceof SymfonyUser) {
            throw new \RuntimeException(
                sprintf(
                    'This method can only be called for "%s" user instance, "%s" given',
                    SymfonyUser::class,
                    \get_class($user)
                )
            );
        }

        return $user->getAccount();
    }
}
