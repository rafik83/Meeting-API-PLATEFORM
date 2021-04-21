<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Api\Application\View\CountryView;

class CountriesTest extends ApiTestCase
{
    // This trait provided by HautelookAliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        static::createClient()->request('GET', '/api/countries');

        self::assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        //Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@context' => '/api/contexts/CountryView',
            '@id' => '/api/countries',
            '@type' => 'hydra:Collection',
            'hydra:member' => [
                [
                    'code' => 'AF',
                    'name' => 'Afghanistan',
                ],
                [
                    'code' => 'AL',
                    'name' => 'Albania',
                ],
            ],
        ]);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        self::assertMatchesResourceCollectionJsonSchema(CountryView::class);
    }

    public function testGetItem(): void
    {
        static::createClient()->request('GET', '/api/countries/FR');

        self::assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        //Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            'code' => 'FR',
            'name' => 'France',
        ]);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        self::assertMatchesResourceItemJsonSchema(CountryView::class);
    }

    public function testNotExistsingCountry(): void
    {
        static::createClient()->request('GET', '/api/countries/XK');

        self::assertResponseStatusCodeSame(404);
    }
}
