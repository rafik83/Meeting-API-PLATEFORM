<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use Doctrine\Persistence\ManagerRegistry;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;

class NomenclatureTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetEn(): void
    {
        $nomenclature = $this->getNomenclature('Goals and objectives');

        $this->request('GET', sprintf('/api/nomenclatures/%d', $nomenclature->getId()), null, [
            'Accept-Language' => 'en',
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertResponseHeaderSame('content-language', 'en');

        // Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@type' => 'Nomenclature',
            'tags' => [
                ['name' => 'buy'],
                ['name' => 'sell'],
            ],
        ]);
    }

    public function testGetFr(): void
    {
        $nomenclature = $this->getNomenclature('Goals and objectives');

        $this->request('GET', sprintf('/api/nomenclatures/%d', $nomenclature->getId()), null, [
            'Accept-Language' => 'fr',
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertResponseHeaderSame('content-language', 'fr');

        // Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@type' => 'Nomenclature',
            'tags' => [
                ['name' => 'acheter'],
                ['name' => 'vendre'],
            ],
        ]);
    }

    public function testGetUnknownLanguage(): void
    {
        $nomenclature = $this->getNomenclature('Goals and objectives');

        $this->request('GET', sprintf('/api/nomenclatures/%d', $nomenclature->getId()), null, [
            'Accept-Language' => 'fy',
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertResponseHeaderSame('content-language', 'en');

        // Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@type' => 'Nomenclature',
            'tags' => [
                ['name' => 'buy'],
                ['name' => 'sell'],
            ],
        ]);
    }

    public function testGetJobPosition(): void
    {
        $this->request('GET', '/api/nomenclatures/job_position', null, [
            'Accept-Language' => 'en',
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertResponseHeaderSame('content-language', 'en');

        // Asserts that the returned JSON is a superset of this one
        self::assertJsonContains([
            '@type' => 'Nomenclature',
            'tags' => [
                ['name' => 'System Engineer'],
            ],
        ]);
    }

    protected function getNomenclature(string $reference): Nomenclature
    {
        $nomenclatureRepository = self::$container->get(ManagerRegistry::class)->getRepository(Nomenclature::class);

        return $nomenclatureRepository->findOneByReference($reference);
    }
}
