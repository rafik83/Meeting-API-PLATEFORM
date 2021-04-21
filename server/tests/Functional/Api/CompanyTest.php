<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use Doctrine\Persistence\ManagerRegistry;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use League\Flysystem\FilesystemOperator;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CompanyTest extends ApiTestCase
{
    // This trait provided by HautelookAliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    public function testSetLogo(): void
    {
        $this->login('member@example.com');
        $company = $this->getCompany('Proximum');

        $file = new UploadedFile(
            __DIR__ . '/../../../fixtures/test/assets/sample-logo.png',
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

        self::assertNotNull($company->getLogo());
        /** @var FilesystemOperator $storage */
        $storage = self::$container->get('companyLogos.storage');
        self::assertTrue($storage->fileExists($company->getLogo()));

        $storage->delete($company->getLogo());
    }

    public function testRemovePreviousLogo(): void
    {
        $account = $this->login('member@example.com');
        $company = $this->getCompany('Proximum');

        $previousLogo = $company->getLogo();
        self::assertNotNull($previousLogo);

        /** @var FilesystemOperator $storage */
        $storage = self::$container->get('companyLogos.storage');
        $storage->write($previousLogo, file_get_contents(__DIR__ . '/../../../fixtures/test/assets/sample-logo.png'));
        self::assertTrue($storage->fileExists($previousLogo));

        $file = new UploadedFile(
            __DIR__ . '/../../../fixtures/test/assets/sample-logo.png',
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

        self::assertFalse($storage->fileExists($previousLogo));
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
            __DIR__ . '/../../../fixtures/test/assets/sample-logo.png',
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
            __DIR__ . '/../../../fixtures/test/assets/sample-logo.png',
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
            __DIR__ . '/../../../fixtures/test/assets/logo.pdf',
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
            __DIR__ . '/../../../fixtures/test/assets/sample-logo.gif',
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
            __DIR__ . '/../../../fixtures/test/assets/logo-too-large.png',
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

    protected function getCompany(string $name): Company
    {
        $companyRepository = self::$container->get(ManagerRegistry::class)->getRepository(Company::class);

        return $companyRepository->findOneBy(['name' => $name]);
    }
}
