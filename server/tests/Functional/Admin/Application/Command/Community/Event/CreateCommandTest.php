<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Admin\Application\Command\Community\Event;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\Event\CreateCommand;
use Proximum\Vimeet365\Admin\Infrastructure\Validator\TagBelongToNomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Infrastructure\Repository\CommunityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCommandTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    private const VALID_PICTURE = __DIR__ . '/../../../../../../Unit/files/event/picture.png';

    public function testValid(): void
    {
        $community = $this->getCommunity('Space industry');
        $eventTags = $community->getEventNomenclature()->getTags()
            ->map(fn (NomenclatureTag $nomenclatureTag): Tag => $nomenclatureTag->getTag())
            ->slice(0, 2)
        ;

        $characterizationTags = $community->getSkillNomenclature()->getTags()
            ->map(fn (NomenclatureTag $nomenclatureTag): Tag => $nomenclatureTag->getTag())
            ->slice(0, 2)
        ;

        $command = new CreateCommand($community);
        $command->name = 'Event Name';
        $command->eventType = Community\Event\EventType::get(Community\Event\EventType::FACE_TO_FACE);
        $command->startDate = new \DateTimeImmutable('2021-01-01T00:00:00.000000Z');
        $command->endDate = new \DateTimeImmutable('2021-01-02T00:00:00.000000Z');
        $command->registerUrl = 'https://vimeet365.events';
        $command->findOutMoreUrl = 'https://vimeet365.events';
        $command->picture = new UploadedFile(self::VALID_PICTURE, 'picture.png', 'image/png', test: true);
        $command->tags = $eventTags;
        $command->characterizationTags = $characterizationTags;

        $errors = $this->validate($command);

        self::assertCount(0, $errors);
    }

    public function testEmpty(): void
    {
        $community = $this->getCommunity('Space industry');

        $command = new CreateCommand($community);

        $errors = $this->validate($command);

        self::assertCount(7, $errors);
        self::assertEquals([
            'name' => 'urn:uuid:' . NotBlank::IS_BLANK_ERROR,
            'eventType' => 'urn:uuid:' . NotNull::IS_NULL_ERROR,
            'startDate' => 'urn:uuid:' . NotNull::IS_NULL_ERROR,
            'endDate' => 'urn:uuid:' . NotNull::IS_NULL_ERROR,
            'registerUrl' => 'urn:uuid:' . NotBlank::IS_BLANK_ERROR,
            'findOutMoreUrl' => 'urn:uuid:' . NotBlank::IS_BLANK_ERROR,
            'picture' => 'urn:uuid:' . NotNull::IS_NULL_ERROR,
        ], $errors);
    }

    public function testInvalid(): void
    {
        $community = $this->getCommunity('Space industry');
        $eventTags = $community->getEventNomenclature()->getTags()
            ->map(fn (NomenclatureTag $nomenclatureTag): Tag => $nomenclatureTag->getTag())
            ->slice(0, 5)
        ;

        $characterizationTags = $community->getSkillNomenclature()->getTags()
            ->map(fn (NomenclatureTag $nomenclatureTag): Tag => $nomenclatureTag->getTag())
            ->slice(0, 5)
        ;

        $command = new CreateCommand($community);
        $command->name = str_repeat('a', 256);
        $command->eventType = Community\Event\EventType::get(Community\Event\EventType::FACE_TO_FACE);
        $command->startDate = new \DateTimeImmutable('2021-01-02T00:00:00.000000Z');
        $command->endDate = new \DateTimeImmutable('2021-01-01T00:00:00.000000Z');
        $command->registerUrl = 'not an url';
        $command->findOutMoreUrl = 'not an url';
        $command->picture = new UploadedFile(self::VALID_PICTURE, 'picture.png', 'image/gif', test: true);
        $command->tags = $characterizationTags;
        $command->characterizationTags = $eventTags;

        $errors = $this->validate($command);

        self::assertCount(15, $errors);
        self::assertEquals([
            'name' => 'urn:uuid:' . Length::TOO_LONG_ERROR,
            'endDate' => 'urn:uuid:' . GreaterThanOrEqual::TOO_LOW_ERROR,
            'registerUrl' => 'urn:uuid:' . Url::INVALID_URL_ERROR,
            'findOutMoreUrl' => 'urn:uuid:' . Url::INVALID_URL_ERROR,
            'tags[0]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
            'tags[1]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
            'tags[2]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
            'tags[3]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
            'tags[4]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
            'tags' => 'urn:uuid:' . Count::TOO_MANY_ERROR,
            'characterizationTags[0]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
            'characterizationTags[1]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
            'characterizationTags[2]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
            'characterizationTags[3]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
            'characterizationTags[4]' => 'urn:uuid:' . TagBelongToNomenclature::INVALID_ERROR,
        ], $errors);
    }

    private function validate(CreateCommand $command): array
    {
        $errors = $this->getValidator()->validate($command);
        $normalizeErrors = $this->getSerializer()->normalize($errors);

        return array_column($normalizeErrors['violations'], 'type', 'propertyPath');
    }

    private function getCommunity(string $name): Community
    {
        return self::getContainer()->get(CommunityRepository::class)->findOneByName($name);
    }

    private function getValidator(): ValidatorInterface
    {
        return self::getContainer()->get(ValidatorInterface::class);
    }

    private function getSerializer(): SerializerInterface
    {
        return self::getContainer()->get(SerializerInterface::class);
    }
}
