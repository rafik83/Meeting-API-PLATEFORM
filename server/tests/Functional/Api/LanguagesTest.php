<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Proximum\Vimeet365\Api\Application\View\CountryView;

class LanguagesTest extends ApiTestCase
{
    public function testGetCollection(): void
    {
        static::createClient()->request('GET', '/api/languages');

        self::assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        //Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@context' => '/api/contexts/LanguageView',
            '@id' => '/api/languages',
            '@type' => 'hydra:Collection',
            'hydra:member' => [
                [
                    'code' => 'ar',
                    'name' => 'Arabic',
                ],
                [
                    'code' => 'bn',
                    'name' => 'Bangla',
                ],
            ],
        ]);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        self::assertMatchesResourceCollectionJsonSchema(CountryView::class);
    }

    public function testGetItem(): void
    {
        static::createClient()->request('GET', '/api/languages/fr');

        self::assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        //Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            'code' => 'fr',
            'name' => 'French',
        ]);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        self::assertMatchesResourceItemJsonSchema(CountryView::class);
    }

    public function testNotExistingLanguage(): void
    {
        static::createClient()->request('GET', '/api/languages/tlh');

        self::assertResponseStatusCodeSame(404);
    }
}
