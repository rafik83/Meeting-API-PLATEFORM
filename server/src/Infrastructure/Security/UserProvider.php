<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Security;

use Proximum\Vimeet365\Infrastructure\Repository\AccountRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function loadUserByUsername(string $username): User
    {
        $account = $this->accountRepository->findOneBy(['email' => $username]);

        if ($account === null) {
            throw new UsernameNotFoundException(sprintf('Unable to find the user %s', $username));
        }

        return new User($account);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass(string $class)
    {
        return $class === User::class;
    }

    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new \RuntimeException(sprintf('This provider only support %s, %s given', User::class, \get_class($user)));
        }

        $this->accountRepository->upgradePassword($user->getAccount(), $newEncodedPassword);
    }
}
