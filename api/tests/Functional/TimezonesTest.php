<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Proximum\Vimeet365\Application\View\CountryView;

class TimezonesTest extends ApiTestCase
{
    public function testGetCollection(): void
    {
        static::createClient()->request('GET', '/api/timezones');

        self::assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        //Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@context' => '/api/contexts/TimezoneView',
            '@id' => '/api/timezones',
            '@type' => 'hydra:Collection',
            'hydra:member' => [
                [
                    'code' => 'America/Eirunepe',
                    'name' => 'Acre Time (Eirunepe)',
                ],
                [
                    'code' => 'America/Rio_Branco',
                    'name' => 'Acre Time (Rio Branco)',
                ],
            ],
        ]);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        self::assertMatchesResourceCollectionJsonSchema(CountryView::class);
    }

    public function testGetItem(): void
    {
        static::createClient()->request('GET', '/api/timezones/Europe/Paris');

        self::assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        //Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            'code' => 'Europe/Paris',
            'name' => 'Central European Time (Paris)',
        ]);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        self::assertMatchesResourceItemJsonSchema(CountryView::class);
    }

    public function testNotExistingTimezone(): void
    {
        static::createClient()->request('GET', '/api/timezones/Europe/Kiribati');

        self::assertResponseStatusCodeSame(404);
    }
}
