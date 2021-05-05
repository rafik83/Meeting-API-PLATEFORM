<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use League\Flysystem\FilesystemOperator;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AccountAvatarTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testSetAvatar(): void
    {
        $account = $this->login('user@example.com');

        self::assertNull($account->getAvatar());

        $file = new UploadedFile(
            __DIR__ . '/../../../fixtures/test/assets/sample-logo.png',
            'sample/logo.png',
            'image/png',
        );

        $response = $this->request(
            'POST',
            sprintf('/api/accounts/%d/avatar', $account->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'file' => $file,
                ],
            ]
        );

        self::assertResponseIsSuccessful();
        self::assertStringStartsWith($_SERVER['CDN_HOST'] . '/accountAvatar/', $response->toArray()['avatar']);

        self::assertNotNull($account->getAvatar());
        /** @var FilesystemOperator $storage */
        $storage = self::$container->get('accountAvatar.storage');
        self::assertTrue($storage->fileExists($account->getAvatar()));

        $storage->delete($account->getAvatar());
    }

    public function testSetEmptyAvatar(): void
    {
        $account = $this->login('user@example.com');

        $response = $this->request(
            'POST',
            sprintf('/api/accounts/%d/avatar', $account->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ]);

        self::assertResponseIsSuccessful();
    }

    public function testRemoveAvatar(): void
    {
        $account = $this->login('member@example.com');
        $avatar = $account->getAvatar();

        self::assertNotNull($avatar);

        /** @var FilesystemOperator $storage */
        $storage = self::$container->get('accountAvatar.storage');
        $storage->write($avatar, file_get_contents(__DIR__ . '/../../../fixtures/test/assets/sample-logo.png'));
        self::assertTrue($storage->fileExists($avatar));

        $response = $this->request(
            'POST',
            sprintf('/api/accounts/%d/avatar', $account->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ]);

        self::assertResponseIsSuccessful();

        self::assertFalse($storage->fileExists($avatar));
        self::assertNull($account->getAvatar());
    }

    public function testSetAvatarNotLoggedIn(): void
    {
        $account = $this->getAccount('user@example.com');

        $file = new UploadedFile(
            __DIR__ . '/../../../fixtures/test/assets/sample-logo.png',
            'sample/logo.png',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/accounts/%d/avatar', $account->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'file' => $file,
                ],
            ]
        );

        self::assertResponseStatusCodeSame(401);
    }

    public function testSetAvatarNotMyUser(): void
    {
        $this->login('user@example.com');
        $account = $this->getAccount('member@example.com');

        $file = new UploadedFile(
            __DIR__ . '/../../../fixtures/test/assets/sample-logo.png',
            'sample/logo.png',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/accounts/%d/avatar', $account->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'file' => $file,
                ],
            ]
        );

        self::assertResponseStatusCodeSame(403);
    }

    public function testSetAvatartNotImage(): void
    {
        $account = $this->login('user@example.com');

        $file = new UploadedFile(
            __DIR__ . '/../../../fixtures/test/assets/logo.pdf',
            'sample/logo.png',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/accounts/%d/avatar', $account->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'file' => $file,
                ],
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'file',
                        'code' => '744f00bc-4389-4c74-92de-9a43cde55534', // INVALID_MIME_TYPE_ERROR
                    ],
                ],
            ]
        );
    }

    public function testSetAvatarAcceptedImageType(): void
    {
        $account = $this->login('user@example.com');

        $file = new UploadedFile(
            __DIR__ . '/../../../fixtures/test/assets/sample-logo.gif',
            'sample-logo.gif',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/accounts/%d/avatar', $account->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'file' => $file,
                ],
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'file',
                        'code' => '744f00bc-4389-4c74-92de-9a43cde55534', // INVALID_MIME_TYPE_ERROR
                    ],
                ],
            ]
        );
    }

    public function testSetAvatarTooBig(): void
    {
        $account = $this->login('user@example.com');

        $file = new UploadedFile(
            __DIR__ . '/../../../fixtures/test/assets/logo-too-large.png',
            'sample/logo-too-large.png',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/accounts/%d/avatar', $account->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'file' => $file,
                ],
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'file',
                        'code' => 'df8637af-d466-48c6-a59d-e7126250a654', // TOO_LARGE_ERROR
                    ],
                ],
            ]
        );
    }
}
