<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Doctrine\Persistence\ManagerRegistry;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Domain\Entity\Company;
use Proximum\Vimeet365\Infrastructure\Repository\AccountRepository;
use Proximum\Vimeet365\Infrastructure\Security\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CompanyTest extends ApiTestCase
{
    // This trait provided by HautelookAliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    protected static $client;

    public function setUp(): void
    {
        self::$client = static::createClient();
    }

    public function testSetLogo(): void
    {
        $this->login('member@example.com');
        $company = $this->getCompany('Proximum');

        $file = new UploadedFile(
            __DIR__ . '/../../fixtures/test/assets/sample-logo.png',
            'sample/logo.png',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/companies/%d/logo', $company->getId()),
            null, [
                'Content-Type' => 'multipart/form-data',
            ], [
                'files' => [
                    'logo' => $file,
                ],
            ]
        );

        self::assertResponseIsSuccessful();
    }

    public function testSetEmptyLogo(): void
    {
        $this->login('member@example.com');
        $company = $this->getCompany('Proximum');

        $this->request(
            'POST',
            sprintf('/api/companies/%d/logo', $company->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'logo',
                        'message' => 'This value should not be null.',
                        'code' => 'ad32d13f-c3d4-423b-909a-857b961eb720',
                    ],
                ],
            ]
        );
    }

    public function testNotLoggedIn(): void
    {
        $company = $this->getCompany('Proximum');

        $file = new UploadedFile(
            __DIR__ . '/../../fixtures/test/assets/sample-logo.png',
            'sample/logo.png',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/companies/%d/logo', $company->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'logo' => $file,
                ],
            ]
        );

        self::assertResponseStatusCodeSame(401);
    }

    public function testNotMyCompany(): void
    {
        $this->login('user@example.com');
        $company = $this->getCompany('Proximum');

        $file = new UploadedFile(
            __DIR__ . '/../../fixtures/test/assets/sample-logo.png',
            'sample/logo.png',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/companies/%d/logo', $company->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'logo' => $file,
                ],
            ]
        );

        self::assertResponseStatusCodeSame(403);
    }

    public function testSetLogoNotImage(): void
    {
        $this->login('member@example.com');
        $company = $this->getCompany('Proximum');

        $file = new UploadedFile(
            __DIR__ . '/../../fixtures/test/assets/logo.pdf',
            'sample/logo.png',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/companies/%d/logo', $company->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'logo' => $file,
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
                        'propertyPath' => 'logo',
                        'code' => '744f00bc-4389-4c74-92de-9a43cde55534', // INVALID_MIME_TYPE_ERROR
                    ],
                ],
            ]
        );
    }

    public function testSetLogoAcceptedImageType(): void
    {
        $this->login('member@example.com');
        $company = $this->getCompany('Proximum');

        $file = new UploadedFile(
            __DIR__ . '/../../fixtures/test/assets/sample-logo.gif',
            'sample-logo.gif',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/companies/%d/logo', $company->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'logo' => $file,
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
                        'propertyPath' => 'logo',
                        'code' => '744f00bc-4389-4c74-92de-9a43cde55534', // INVALID_MIME_TYPE_ERROR
                    ],
                ],
            ]
        );
    }

    public function testSetLogoTooBig(): void
    {
        $this->login('member@example.com');
        $company = $this->getCompany('Proximum');

        $file = new UploadedFile(
            __DIR__ . '/../../fixtures/test/assets/logo-too-large.png',
            'sample/logo-too-large.png',
            'image/png',
        );

        $this->request(
            'POST',
            sprintf('/api/companies/%d/logo', $company->getId()),
            null, [
            'Content-Type' => 'multipart/form-data',
        ], [
                'files' => [
                    'logo' => $file,
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
                        'propertyPath' => 'logo',
                        'code' => 'df8637af-d466-48c6-a59d-e7126250a654', // TOO_LARGE_ERROR
                    ],
                ],
            ]
        );
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

    protected function getCompany(string $name): Company
    {
        $companyRepository = self::$container->get(ManagerRegistry::class)->getRepository(Company::class);

        return $companyRepository->findOneBy(['name' => $name]);
    }
}
