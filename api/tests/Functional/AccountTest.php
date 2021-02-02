<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Domain\Entity\Account;

class AccountTest extends ApiTestCase
{
    // This trait provided by HautelookAliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/accounts');

        self::assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@context' => '/api/contexts/Account',
            '@id' => '/api/accounts',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 31,
            'hydra:view' => [
                '@id' => '/api/accounts?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/api/accounts?page=1',
                'hydra:last' => '/api/accounts?page=4',
                'hydra:next' => '/api/accounts?page=2',
            ],
        ]);

        self::assertCount(10, $response->toArray()['hydra:member']);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        self::assertMatchesResourceCollectionJsonSchema(Account::class);
    }

    public function testCreate(): void
    {
        static::createClient()->request('POST', '/api/accounts', [
            'headers' => [
                'content-type' => 'application/ld+json',
            ],
            'body' => \json_encode([
                'email' => 'new@example.com',
                'password' => 'Passw0rd$',
                'firstName' => 'New',
                'lastName' => 'Example',
                'acceptedTermsAndCondition' => true,
            ]),
        ]);

        self::assertResponseIsSuccessful();
    }

    public function testCreateNonUniqueEmailFields(): void
    {
        $response = static::createClient()->request(
            'POST',
            '/api/accounts',
            [
                'headers' => [
                    'content-type' => 'application/ld+json',
                ],
                'body' => \json_encode(
                    [
                        'email' => 'user@example.com',
                        'password' => 'Passw0rd$',
                        'firstName' => 'New',
                        'lastName' => 'Example',
                        'acceptedTermsAndCondition' => true,
                    ]
                ),
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'email',
                    'message' => 'The "user@example.com" reference exists.',
                ],
            ],
        ]);

        self::assertCount(1, $response->toArray(false)['violations']);
    }

    public function testCreateInvalidFields(): void
    {
        $response = static::createClient()->request('POST', '/api/accounts', [
            'headers' => [
                'content-type' => 'application/ld+json',
            ],
            'body' => \json_encode([
                'email' => 'new.example.com',
                'password' => 'Passw0rd$',
                'firstName' => 'New',
                'lastName' => 'Example',
                'acceptedTermsAndCondition' => true,
            ]),
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'email',
                    'message' => 'This value is not a valid email address.',
                ],
            ],
        ]);

        self::assertCount(1, $response->toArray(false)['violations']);
    }

    public function testCreateEmptyFields(): void
    {
        $response = static::createClient()->request('POST', '/api/accounts', [
            'headers' => [
                'content-type' => 'application/ld+json',
            ],
            'body' => \json_encode([
                'email' => '',
                'password' => '',
                'firstName' => '',
                'lastName' => '',
                'acceptedTermsAndCondition' => false,
            ]),
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'email',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'password',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'firstName',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'lastName',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'acceptedTermsAndCondition',
                    'message' => 'This value should be true.',
                ],
            ],
        ]);

        self::assertCount(5, $response->toArray(false)['violations']);
    }
}
