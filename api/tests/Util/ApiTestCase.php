<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Util;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase as ApiPlatformApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Infrastructure\Repository\AccountRepository;
use Proximum\Vimeet365\Infrastructure\Security\User;

abstract class ApiTestCase extends ApiPlatformApiTestCase
{
    protected static Client $client;

    public function setUp(): void
    {
        self::$client = static::createClient();
    }

    protected function login(string $username): Account
    {
        $account = $this->getAccount($username);

        self::$client->getKernelBrowser()->loginUser(new User($account), 'main');

        return $account;
    }

    protected function getAccount(string $email): Account
    {
        $accountRepository = self::$container->get(AccountRepository::class);

        return $accountRepository->findOneByEmail($email);
    }

    protected function request(string $method, string $url, ?array $body = null, array $headers = [], array $extra = [])
    {
        return self::$client->request(
            $method,
            $url,
            [
                'headers' => array_merge(
                    [
                        'content-type' => 'application/ld+json',
                    ],
                    $headers
                ),
                'extra' => $extra,
                'body' => \json_encode($body),
            ]
        );
    }
}
