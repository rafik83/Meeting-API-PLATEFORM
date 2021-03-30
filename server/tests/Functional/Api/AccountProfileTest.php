<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;

class AccountProfileTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testUpdateProfile(): void
    {
        $account = $this->login('user@example.com');

        $tag = $this->getTagId('System Engineer');

        $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/profile', $account->getId()),
            [
                'jobPosition' => $tag,
                'jobTitle' => 'Responsable Technique',
                'languages' => ['fr', 'en', 'tlh'],
                'country' => 'FR',
                'timezone' => 'Europe/Paris',
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseIsSuccessful();
    }

    public function testUpdateProfileNotLoggedIn(): void
    {
        $account = $this->getAccount('user@example.com');

        $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/profile', $account->getId()),
            [
                'jobPosition' => null,
                'jobTitle' => 'Responsable Technique',
                'languages' => ['fr', 'en', 'tlh'],
                'country' => 'FR',
                'timezone' => 'Europe/Paris',
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(401);
    }

    public function testUpdateProfileNotMyProfile(): void
    {
        $this->login('user@example.com');
        $account = $this->getAccount('member@example.com');

        $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/profile', $account->getId()),
            [
                'jobPosition' => null,
                'jobTitle' => 'Responsable Technique',
                'languages' => ['fr', 'en', 'tlh'],
                'country' => 'FR',
                'timezone' => 'Europe/Paris',
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(403);
    }

    public function testUpdateProfileInvalidFields(): void
    {
        $account = $this->login('user@example.com');

        $tag = $this->getTagId('Satellites');

        $response = $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/profile', $account->getId()),
            [
                'jobPosition' => $tag,
                'jobTitle' => str_repeat('abcd', 65),
                'languages' => ['fr', 'de', 'it', 'zzz'],
                'country' => 'FRO',
                'timezone' => 'Europe/Miami',
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(422);
        self::assertCount(6, $response->toArray(false)['violations']);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'jobPosition',
                        'code' => '0a10ed7e-36f5-4b27-904d-2b5053c35257',
                    ],
                    [
                        'propertyPath' => 'jobTitle',
                        'message' => 'This value is too long. It should have 255 characters or less.',
                    ],
                    [
                        'propertyPath' => 'languages[3]',
                        'message' => 'This value is not a valid language.',
                    ],
                    [
                        'propertyPath' => 'languages',
                        'message' => 'This collection should contain 3 elements or less.',
                    ],
                    [
                        'propertyPath' => 'country',
                        'message' => 'This value is not a valid country.',
                    ],
                    [
                        'propertyPath' => 'timezone',
                        'message' => 'This value is not a valid timezone.',
                    ],
                ],
            ]
        );
    }

    public function testUpdateProfileEmptyFields(): void
    {
        $account = $this->login('user@example.com');

        $response = $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/profile', $account->getId()),
            [
                'jobPosition' => null,
                'jobTitle' => '',
                'languages' => [],
                'country' => null,
                'timezone' => null,
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(422);
        self::assertCount(3, $response->toArray(false)['violations']);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'languages',
                        'message' => 'This collection should contain 1 element or more.',
                    ],
                    [
                        'propertyPath' => 'country',
                        'message' => 'This value should not be blank.',
                    ],
                    [
                        'propertyPath' => 'timezone',
                        'message' => 'This value should not be blank.',
                    ],
                ],
            ]
        );
    }
}
