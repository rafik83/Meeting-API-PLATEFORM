<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Infrastructure\Hubspot;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use HubSpot\Client\Crm\Contacts\ApiException;
use HubSpot\Factory;
use PHPUnit\Framework\TestCase;
use Proximum\Vimeet365\Core\Application\Hubspot\Model\Company;
use Proximum\Vimeet365\Core\Application\Hubspot\Model\Contact;
use Proximum\Vimeet365\Core\Infrastructure\Hubspot\Client;

class ClientTest extends TestCase
{
    public function testFindContact(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(
                [
                    'total' => 1,
                    'results' => [
                        [
                            'id' => '14970951',
                            'properties' => [
                                'createdate' => '2021-02-09T08:41:54.070Z',
                                'email' => 'john@example.com',
                                'firstname' => 'John',
                                'hs_object_id' => '14970951',
                                'lastmodifieddate' => '2021-04-29T09:00:25.899Z',
                                'lastname' => 'Doe',
                            ],
                            'createdAt' => '2021-02-09T08:41:54.070Z',
                            'updatedAt' => '2021-04-29T09:00:25.899Z',
                            'archived' => false,
                        ],
                    ],
                ],
                JSON_THROW_ON_ERROR
            )),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));
        $contact = $hubspot->findContact('john@example.com');

        self::assertEquals(
            new Contact(
                '14970951',
                [
                    'email' => 'john@example.com',
                    'firstname' => 'John',
                    'lastname' => 'Doe',
                ]
            ),
            $contact
        );
    }

    public function testCreateContact(): void
    {
        $mock = new MockHandler([
            new Response(201, [], json_encode(
                [
                    'id' => '14970951',
                    'properties' => [
                        'createdate' => '2021-02-09T08:41:54.070Z',
                        'email' => 'john@example.com',
                        'firstname' => 'John',
                        'hs_object_id' => '14970951',
                        'lastmodifieddate' => '2021-04-29T09:00:25.899Z',
                        'lastname' => 'Doe',
                    ],
                    'createdAt' => '2021-02-09T08:41:54.070Z',
                    'updatedAt' => '2021-04-29T09:00:25.899Z',
                    'archived' => false,
                ],
                JSON_THROW_ON_ERROR
            )),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));
        $contact = $hubspot->createContact(
            new Contact(null, ['email' => 'john@example.com', 'firstname' => 'John', 'lastname' => 'Doe'])
        );

        self::assertEquals(
            new Contact(
                '14970951', [
                    'email' => 'john@example.com',
                    'firstname' => 'John',
                    'lastname' => 'Doe',
                ]
            ),
            $contact
        );
    }

    public function testCreateContactDuplicateEmail(): void
    {
        $mock = new MockHandler([
            new Response(409, [], json_encode(
                [
                    'status' => 'error',
                    'message' => 'Contact already exists. Existing ID: 14970951',
                    'correlationId' => 'da9726f1-9404-4db5-9c8a-5341503daec4',
                    'category' => 'CONFLICT',
                ],
                JSON_THROW_ON_ERROR
            )),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Contact already exists. Existing ID: 14970951');

        $hubspot->createContact(
            new Contact(null, ['email' => 'john@example.com', 'firstname' => 'John', 'lastname' => 'Doe'])
        );
    }

    public function testGetContactCompanyId(): void
    {
        $mock = new MockHandler(
            [
                new Response(
                    200, [], json_encode(
                        [
                            'results' => [
                                [
                                    'id' => '1944630924',
                                    'type' => 'contact_to_company',
                                ],
                            ],
                        ],
                        JSON_THROW_ON_ERROR
                    )
                ),
            ]
        );

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));
        $companyId = $hubspot->getContactCompanyId('14970951');

        self::assertEquals('1944630924', $companyId);
    }

    public function testGetContactCompanyIdContactNotFound(): void
    {
        $mock = new MockHandler([new Response(200, [], json_encode(['results' => []]))]);

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));
        $companyId = $hubspot->getContactCompanyId('14970951');

        self::assertEquals(null, $companyId);
    }

    public function testFindCompany(): void
    {
        $mock = new MockHandler(
            [
                new Response(
                    200, [], json_encode(
                        [
                            'id' => '1944630924',
                            'properties' => [
                                'country' => 'France',
                                'createdate' => '2019-05-09T08:40:09.660Z',
                                'description' => 'A description',
                                'domain' => 'vimeet365.events.com',
                                'hs_lastmodifieddate' => '2021-04-29T09:00:27.094Z',
                                'hs_object_id' => '1944630924',
                                'name' => 'Vimeet365',
                                'website' => 'vimeet365.events.com',
                            ],
                            'createdAt' => '2019-05-09T08:40:09.660Z',
                            'updatedAt' => '2021-04-29T09:00:27.094Z',
                            'archived' => false,
                        ],
                        JSON_THROW_ON_ERROR
                    )
                ),
            ]
        );

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));
        $company = $hubspot->findCompany('1944630924');

        self::assertEquals(new Company('1944630924', [
            'country' => 'France',
            'description' => 'A description',
            'domain' => 'vimeet365.events.com',
            'name' => 'Vimeet365',
            'website' => 'vimeet365.events.com',
        ]), $company);
    }

    public function testFindCompanyNotFound(): void
    {
        $mock = new MockHandler([new Response(404)]);

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));
        $company = $hubspot->findCompany('1944630924');

        self::assertNull($company);
    }

    public function testFindCompaniesByDomain(): void
    {
        $mock = new MockHandler(
            [
                new Response(
                    200, [], json_encode(
                        [
                            'total' => 2,
                            'results' => [
                                [
                                    'id' => '2565911836',
                                    'properties' => [
                                        'country' => 'France',
                                        'createdate' => '2019-11-08T11:12:33.147Z',
                                        'description' => 'Vimeet est une plateforme de gestion d\'événements physiques ou dématérialisés.',
                                        'domain' => 'vimeet.events',
                                        'hs_lastmodifieddate' => '2021-04-27T11:41:55.537Z',
                                        'hs_object_id' => '2565911836',
                                        'name' => 'VIMEET',
                                        'website' => 'vimeet.events',
                                    ],
                                    'createdAt' => '2019-11-08T11:12:33.147Z',
                                    'updatedAt' => '2021-04-27T11:41:55.537Z',
                                    'archived' => false,
                                ],
                                [
                                    'id' => '5456066506',
                                    'properties' => [
                                        'country' => 'France',
                                        'createdate' => '2021-02-26T12:30:15.418Z',
                                        'description' => 'Vimeet: The leads factory',
                                        'domain' => 'paris-space-week.vimeet.events',
                                        'hs_lastmodifieddate' => '2021-04-25T00:36:57.778Z',
                                        'hs_object_id' => '5456066506',
                                        'name' => 'Vimeet',
                                        'website' => 'paris-space-week.vimeet.events',
                                    ],
                                    'createdAt' => '2021-02-26T12:30:15.418Z',
                                    'updatedAt' => '2021-04-25T00:36:57.778Z',
                                    'archived' => false,
                                ],
                            ],
                        ],
                        JSON_THROW_ON_ERROR
                    )
                ),
            ]
        );

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));
        $companies = $hubspot->findCompaniesByDomain('vimeet.events');

        self::assertEquals([
            new Company('2565911836', [
                'country' => 'France',
                'description' => 'Vimeet est une plateforme de gestion d\'événements physiques ou dématérialisés.',
                'domain' => 'vimeet.events',
                'name' => 'VIMEET',
                'website' => 'vimeet.events',
            ]),
            new Company('5456066506', [
                'country' => 'France',
                'description' => 'Vimeet: The leads factory',
                'domain' => 'paris-space-week.vimeet.events',
                'name' => 'Vimeet',
                'website' => 'paris-space-week.vimeet.events',
            ]),
        ], $companies);
    }

    public function testLinkContactAndCompany(): void
    {
        $mock = new MockHandler(
            [
                new Response(
                    200, [], json_encode(
                        [
                            'id' => '14970951',
                            'properties' => [
                                'createdate' => '2021-02-09T08:41:54.070Z',
                                'hs_object_id' => '14970951',
                                'lastmodifieddate' => '2021-04-29T09:00:25.899Z',
                            ],
                            'createdAt' => '2021-02-09T08:41:54.070Z',
                            'updatedAt' => '2021-04-29T09:00:25.899Z',
                            'archived' => false,
                            'associations' => [
                                'companies' => [
                                    'results' => [
                                        [
                                            'id' => '1944630924',
                                            'type' => 'contact_to_company',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        JSON_THROW_ON_ERROR
                    )
                ),
            ]
        );

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));
        $hubspot->linkContactAndCompany('14970951', '1944630924');

        self::assertTrue(true, 'No exception');
    }

    public function testCreateCompany(): void
    {
        $mock = new MockHandler(
            [
                new Response(
                    201, [], json_encode(
                        [
                            'id' => '1944630924',
                            'properties' => [
                                'country' => 'France',
                                'createdate' => '2019-05-09T08:40:09.660Z',
                                'description' => 'A description',
                                'domain' => 'vimeet365.events.com',
                                'hs_lastmodifieddate' => '2021-04-29T09:00:27.094Z',
                                'hs_object_id' => '1944630924',
                                'name' => 'Vimeet365',
                                'website' => 'vimeet365.events.com',
                            ],
                            'createdAt' => '2019-05-09T08:40:09.660Z',
                            'updatedAt' => '2021-04-29T09:00:27.094Z',
                            'archived' => false,
                        ],
                        JSON_THROW_ON_ERROR
                    )
                ),
            ]
        );

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $hubspot = new Client(Factory::create($guzzleClient));
        $company = $hubspot->createCompany(new Company(null, [
            'country' => 'France',
            'description' => 'A description',
            'domain' => 'vimeet365.events.com',
            'name' => 'Vimeet365',
            'website' => 'vimeet365.events.com',
        ]));

        self::assertEquals(new Company('1944630924', [
            'country' => 'France',
            'description' => 'A description',
            'domain' => 'vimeet365.events.com',
            'name' => 'Vimeet365',
            'website' => 'vimeet365.events.com',
        ]), $company);
    }
}
