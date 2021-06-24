<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Event;

use Proximum\Vimeet365\Admin\Infrastructure\Validator as AssertVimeet365;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCommand
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    public string $name;

    /**
     * @Assert\NotNull
     */
    public ?Community\Event\EventType $eventType = null;

    /**
     * @Assert\NotNull
     */
    public ?\DateTimeImmutable $startDate = null;

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(propertyPath="startDate")
     */
    public ?\DateTimeImmutable $endDate = null;

    /**
     * @Assert\NotBlank
     * @Assert\Url
     */
    public string $registerUrl = '';

    /**
     * @Assert\NotBlank
     * @Assert\Url
     */
    public string $findOutMoreUrl = '';

    /**
     * @Assert\NotNull
     * @Assert\Image(maxSize="1M", mimeTypes={"image/png", "image/jpeg"})
     */
    public ?UploadedFile $picture = null;

    /**
     * @var Tag[]
     *
     * @Assert\All(
     *     @AssertVimeet365\TagBelongToNomenclature(nomenclaturePropertyPath="community.eventNomenclature")
     * )
     * @Assert\Count(max=4)
     */
    public array $tags = [];

    /**
     * @var Tag[]
     *
     * @Assert\All(
     *     @AssertVimeet365\TagBelongToNomenclature(nomenclaturePropertyPath="community.skillNomenclature")
     * )
     */
    public array $characterizationTags = [];

    public bool $published = false;

    public function __construct(
        private Community $community
    ) {
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }
}
