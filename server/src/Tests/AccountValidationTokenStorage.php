<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests;

use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Security\AccountValidationTokenStorageInterface;

class AccountValidationTokenStorage implements AccountValidationTokenStorageInterface
{
    private static array $tokens = [];

    private function buildKey(Account $account): string
    {
        return $account->getEmail();
    }

    public function generateToken(Account $account): string
    {
        self::$tokens[$this->buildKey($account)] = '15e29216-2cd3-4dc1-8205-3fe4ca8af72f';

        return '15e29216-2cd3-4dc1-8205-3fe4ca8af72f';
    }

    public function exists(Account $account, string $token): bool
    {
        $key = $this->buildKey($account);

        return \array_key_exists($key, self::$tokens);
    }
}
