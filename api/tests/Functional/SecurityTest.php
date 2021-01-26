<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class SecurityTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testLoginValid(): void
    {
        static::createClient()->request(
            'POST',
            '/api/login',
            [
                'headers' => ['content-type' => 'application/json'],
                'body' => \json_encode(['username' => 'user@example.com', 'password' => 'password']),
            ]
        );

        self::assertResponseIsSuccessful();
    }

    public function testLoginInvalid(): void
    {
        static::createClient()->request(
            'POST',
            '/api/login',
            [
                'headers' => ['content-type' => 'application/json'],
                'body' => \json_encode(['username' => 'user@example.com', 'password' => 'invalid']),
            ]
        );

        self::assertJsonContains(['error' => 'Invalid credentials.']);
    }
}
