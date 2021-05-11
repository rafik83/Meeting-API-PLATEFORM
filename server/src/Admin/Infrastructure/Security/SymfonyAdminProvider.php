<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Security;

use Proximum\Vimeet365\Core\Infrastructure\Repository\AdminRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SymfonyAdminProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function loadUserByUsername(string $username): SymfonyAdmin
    {
        $admin = $this->adminRepository->findOneBy(['email' => $username]);

        if ($admin === null) {
            throw new UsernameNotFoundException(sprintf('Unable to find the user %s', $username));
        }

        return new SymfonyAdmin($admin);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass(string $class): bool
    {
        return $class === SymfonyAdmin::class;
    }

    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof SymfonyAdmin) {
            throw new \RuntimeException(sprintf('This provider only support %s, %s given', SymfonyAdmin::class, \get_class($user)));
        }

        $this->adminRepository->upgradePassword($user->getUser(), $newEncodedPassword);
    }
}
