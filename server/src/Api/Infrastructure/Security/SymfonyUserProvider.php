<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Security;

use Proximum\Vimeet365\Core\Infrastructure\Repository\AccountRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SymfonyUserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function loadUserByUsername(string $username): SymfonyUser
    {
        return $this->loadUserByIdentifier($username);
    }

    public function loadUserByIdentifier(string $username): SymfonyUser
    {
        $account = $this->accountRepository->findOneBy(['email' => $username]);

        if ($account === null) {
            throw new UsernameNotFoundException(sprintf('Unable to find the user %s', $username));
        }

        return new SymfonyUser($account);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === SymfonyUser::class;
    }

    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof SymfonyUser) {
            throw new \RuntimeException(sprintf('This provider only support %s, %s given', SymfonyUser::class, \get_class($user)));
        }

        $this->accountRepository->upgradePassword($user->getAccount(), $newEncodedPassword);
    }
}
