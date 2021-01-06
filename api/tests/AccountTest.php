<?php
namespace Proximum\Vimeet365\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Entity\Account;

class AccountTest extends ApiTestCase
{
    // This trait provided by HautelookAliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/accounts');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/api/contexts/Account',
            '@id' => '/api/accounts',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 30,
            'hydra:view' => [
                '@id' => '/api/accounts?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/api/accounts?page=1',
                'hydra:last' => '/api/accounts?page=3',
                'hydra:next' => '/api/accounts?page=2',
            ],
        ]);

        $this->assertCount(10, $response->toArray()['hydra:member']);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        $this->assertMatchesResourceCollectionJsonSchema(Account::class);
    }
}