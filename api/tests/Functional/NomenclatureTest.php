<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Doctrine\Persistence\ManagerRegistry;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;

class NomenclatureTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    protected static $client;

    public function setUp(): void
    {
        self::$client = static::createClient();
    }

    public function testGetEn(): void
    {
        $nomenclature = $this->getNomenclature('Goals and objectives');

        self::$client->request('GET', sprintf('/api/nomenclatures/%d', $nomenclature->getId()), [
            'headers' => [
                'Accept-Language' => 'en',
            ],
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertResponseHeaderSame('content-language', 'en');

        // Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@type' => 'Nomenclature',
            'tags' => [
                ['tag' => ['name' => 'buy']],
                ['tag' => ['name' => 'sell']],
            ],
        ]);
    }

    public function testGetFr(): void
    {
        $nomenclature = $this->getNomenclature('Goals and objectives');

        self::$client->request('GET', sprintf('/api/nomenclatures/%d', $nomenclature->getId()), [
            'headers' => [
                'Accept-Language' => 'fr',
            ],
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertResponseHeaderSame('content-language', 'fr');

        // Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@type' => 'Nomenclature',
            'tags' => [
                ['tag' => ['name' => 'acheter']],
                ['tag' => ['name' => 'vendre']],
            ],
        ]);
    }

    public function testGetUnknownLanguage(): void
    {
        $nomenclature = $this->getNomenclature('Goals and objectives');

        self::$client->request('GET', sprintf('/api/nomenclatures/%d', $nomenclature->getId()), [
            'headers' => [
                'Accept-Language' => 'fy',
            ],
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertResponseHeaderSame('content-language', 'en');

        // Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@type' => 'Nomenclature',
            'tags' => [
                ['tag' => ['name' => 'buy']],
                ['tag' => ['name' => 'sell']],
            ],
        ]);
    }

    protected function getNomenclature(string $name): Nomenclature
    {
        if (self::$container === null) {
            self::$client = static::createClient();
        }

        $nomenclatureRepository = self::$container->get(ManagerRegistry::class)->getRepository(Nomenclature::class);

        return $nomenclatureRepository->findOneByName($name);
    }
}
