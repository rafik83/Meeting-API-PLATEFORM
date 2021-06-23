<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Security;

use Predis\Client;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Security\AccountValidationTokenStorageInterface;
use Symfony\Component\Uid\Uuid;

class AccountValidationTokenStorage implements AccountValidationTokenStorageInterface
{
    public function __construct(private Client $redis)
    {
    }

    private function buildKey(Account $account): string
    {
        return 'account:validation:' . $account->getId();
    }

    private function buildToken(): string
    {
        return (string) Uuid::v6();
    }

    public function generateToken(Account $account): string
    {
        $token = $this->buildToken();
        /*
            Store the token during 43200 sec (1/2 Day)
         **/
        $tokenExpirationTime = 1 * 60 * 60 * 12;

        $this->redis->setex($this->buildKey($account), $tokenExpirationTime, $token);

        return $token;
    }

    public function exists(Account $account, string $token): bool
    {
        $key = $this->buildKey($account);

        if ($this->redis->exists($key) === 0) {
            return false;
        }

        $foundToken = $this->redis->get($key);

        if (!\is_null($foundToken) && $foundToken == $token) {
            $this->redis->del($key);

            return true;
        }

        return false;
    }
}
