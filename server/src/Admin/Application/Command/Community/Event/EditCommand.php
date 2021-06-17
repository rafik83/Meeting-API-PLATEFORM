<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Event;

use Proximum\Vimeet365\Admin\Infrastructure\Validator as AssertVimeet365;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class EditCommand
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    public string $name;

    public Community\EventType $eventType;

    /**
     * @Assert\NotNull
     */
    public ?\DateTimeImmutable $startDate;

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(propertyPath="startDate")
     */
    public ?\DateTimeImmutable $endDate;

    /**
     * @Assert\NotBlank
     * @Assert\Url
     */
    public string $registerUrl;

    /**
     * @Assert\NotBlank
     * @Assert\Url
     */
    public string $findOutMoreUrl;

    /**
     * @Assert\Image(maxSize="1M", mimeTypes={"image/png", "image/jpeg"})
     */
    public ?UploadedFile $picture = null;

    /**
     * @var Tag[]
     *
     * @Assert\All(
     *     @AssertVimeet365\TagBelongToNomenclature(nomenclaturePropertyPath="event.community.eventNomenclature")
     * )
     * @Assert\Count(max=4)
     */
    public array $tags = [];

    /**
     * @var Tag[]
     *
     * @Assert\All(
     *     @AssertVimeet365\TagBelongToNomenclature(nomenclaturePropertyPath="event.community.skillNomenclature")
     * )
     */
    public array $characterizationTags = [];

    public bool $published = false;

    public function __construct(
        private Community\Event $event
    ) {
        $this->name = $this->event->getName();
        $this->eventType = $this->event->getEventType();
        $this->startDate = $this->event->getStartDate();
        $this->endDate = $this->event->getEndDate();
        $this->registerUrl = $this->event->getRegisterUrl();
        $this->findOutMoreUrl = $this->event->getFindOutMoreUrl();
        $this->tags = $this->event->getTags()->getValues();
        $this->characterizationTags = $this->event->getCharacterizationTags()->getValues();
        $this->published = $this->event->isPublished();
    }

    public function getEvent(): Community\Event
    {
        return $this->event;
    }
}
