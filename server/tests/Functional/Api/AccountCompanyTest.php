<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use Doctrine\Persistence\ManagerRegistry;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;

class AccountCompanyTest extends ApiTestCase
{
    // This trait provided by HautelookAliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    public function testCreate(): void
    {
        $account = $this->login('user@example.com');

        $this->request(
            'POST',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => 'Proximum365',
                'countryCode' => 'FR',
                'website' => 'http://vimeet356.events',
                'activity' => 'Organizer events',
            ]
        );

        self::assertResponseIsSuccessful();
    }

    public function testCreateNotLoggedIn(): void
    {
        $account = $this->getAccount('user@example.com');

        $this->request(
            'POST',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => 'Proximum365',
                'countryCode' => 'FR',
                'website' => 'http://vimeet356.events',
                'activity' => 'Organizer events',
            ]
        );

        self::assertResponseStatusCodeSame(401);
    }

    public function testCreateNotMyAccount(): void
    {
        $this->login('user@example.com');
        $account = $this->getAccount('member@example.com');

        $response = $this->request(
            'POST',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => 'Proximum365',
                'countryCode' => 'FR',
                'website' => 'http://vimeet356.events',
                'activity' => 'Organizer events',
            ]
        );

        self::assertResponseStatusCodeSame(403);
    }

    public function testCreateEmptyFields(): void
    {
        $account = $this->login('user@example.com');

        $response = $this->request(
            'POST',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => '',
                'countryCode' => '',
                'website' => '',
                'activity' => '',
            ]
        );

        self::assertCount(3, $response->toArray(false)['violations']);
    }

    public function testCreateInvalidFields(): void
    {
        $account = $this->login('user@example.com');

        $response = $this->request(
            'POST',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => 'Proximum365',
                'countryCode' => 'FRA',
                'website' => 'vimeet356.events',
                'activity' => str_repeat('too long', 50),
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'countryCode',
                        'message' => 'This value is not a valid country.',
                    ],
                    [
                        'propertyPath' => 'website',
                        'message' => 'This value is not a valid URL.',
                    ],
                    [
                        'propertyPath' => 'activity',
                        'message' => 'This value is too long. It should have 300 characters or less.',
                    ],
                ],
            ]
        );

        self::assertCount(3, $response->toArray(false)['violations']);
    }

    public function testGetUserWithCompany(): void
    {
        $account = $this->login('member@example.com');

        $this->request('GET', sprintf('/api/accounts/%d', $account->getId()));

        self::assertResponseIsSuccessful();

        self::assertJsonContains(
            [
                'company' => [
                    '@context' => '/api/contexts/Company',
                    '@type' => 'Company',
                    'name' => 'Proximum',
                    'countryCode' => 'FR',
                    'website' => 'http://proximum.events',
                ],
            ]
        );
    }

    public function testUpdate(): void
    {
        $account = $this->login('member@example.com');

        $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => 'Proximum365',
                'countryCode' => 'FR',
                'website' => 'http://vimeet356.events',
                'activity' => 'Organizer events',
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseIsSuccessful();
    }

    public function testUpdateNotLoggedIn(): void
    {
        $account = $this->getAccount('member@example.com');

        $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => 'Proximum365',
                'countryCode' => 'FR',
                'website' => 'http://vimeet356.events',
                'activity' => 'Organizer events',
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(401);
    }

    public function testUpdateOtherAccount(): void
    {
        $this->login('member@example.com');
        $account = $this->getAccount('user@example.com');

        $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => 'Proximum365',
                'countryCode' => 'FR',
                'website' => 'http://vimeet356.events',
                'activity' => 'Organizer events',
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(403);
    }

    public function testUpdateNotCompanyDefined(): void
    {
        $account = $this->login('user@example.com');

        $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => 'Proximum365',
                'countryCode' => 'FR',
                'website' => 'http://vimeet356.events',
                'activity' => 'Organizer events',
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(404);
    }

    public function testUpdateEmptyFields(): void
    {
        $account = $this->login('member@example.com');

        $response = $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => '',
                'countryCode' => '',
                'website' => '',
                'activity' => '',
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'name',
                        'message' => 'This value should not be blank.',
                    ],
                    [
                        'propertyPath' => 'countryCode',
                        'message' => 'This value should not be blank.',
                    ],
                    [
                        'propertyPath' => 'website',
                        'message' => 'This value should not be blank.',
                    ],
                ],
            ]
        );

        self::assertCount(3, $response->toArray(false)['violations']);
    }

    public function testUpdateInvalidFields(): void
    {
        $account = $this->login('member@example.com');

        $response = $this->request(
            'PATCH',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'name' => 'Proximum365',
                'countryCode' => 'FRA',
                'website' => 'vimeet356.events',
                'activity' => str_repeat('too long', 50),
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'countryCode',
                        'message' => 'This value is not a valid country.',
                    ],
                    [
                        'propertyPath' => 'website',
                        'message' => 'This value is not a valid URL.',
                    ],
                    [
                        'propertyPath' => 'activity',
                        'message' => 'This value is too long. It should have 300 characters or less.',
                    ],
                ],
            ]
        );

        self::assertCount(3, $response->toArray(false)['violations']);
    }

    public function testLink(): void
    {
        $account = $this->login('member@example.com');
        $company = $this->getCompany('Proximum');

        $this->request(
            'PUT',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'company' => $company->getId(),
            ]
        );

        self::assertResponseIsSuccessful();
    }

    public function testLinkNotLoggedIn(): void
    {
        $account = $this->getAccount('member@example.com');
        $company = $this->getCompany('Proximum');

        $this->request(
            'PUT',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'company' => $company->getId(),
            ]
        );

        self::assertResponseStatusCodeSame(401);
    }

    public function testLinkOtherAccount(): void
    {
        $this->login('member@example.com');
        $account = $this->getAccount('user@example.com');
        $company = $this->getCompany('Proximum');

        $this->request(
            'PUT',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'company' => $company->getId(),
            ]
        );

        self::assertResponseStatusCodeSame(403);
    }

    public function testLinkUnknownCompany(): void
    {
        $account = $this->login('member@example.com');

        $response = $this->request(
            'PUT',
            sprintf('/api/accounts/%d/company', $account->getId()),
            [
                'company' => 0,
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'violations' => [
                    [
                        'propertyPath' => 'company',
                        'message' => "The company doesn't exist",
                        'code' => 'd3ead236-bee1-4e1d-ad41-2b2d7c303dc3',
                    ],
                ],
            ]
        );

        self::assertCount(1, $response->toArray(false)['violations']);
    }

    protected function getCompany(string $name): Company
    {
        $companyRepository = self::$container->get(ManagerRegistry::class)->getRepository(Company::class);

        return $companyRepository->findOneBy(['name' => $name]);
    }
}
