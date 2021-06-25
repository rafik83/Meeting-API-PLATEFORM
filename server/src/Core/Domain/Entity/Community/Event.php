<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Infrastructure\Repository\CommunityEventRepository;

/**
 * @ORM\Entity(repositoryClass=CommunityEventRepository::class)
 * @ORM\Table(name="community_event")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Community $community;

    /**
     * @ORM\Column
     */
    private string $name;

    /**
     * @ORM\Column(type="community_event_type")
     */
    private EventType $eventType;

    /**
     * @ORM\Column(type="datetimetz_immutable")
     */
    private \DateTimeImmutable $startDate;

    /**
     * @ORM\Column(type="datetimetz_immutable")
     */
    private \DateTimeImmutable $endDate;

    /**
     * @ORM\Column
     */
    private string $registerUrl;

    /**
     * @ORM\Column
     */
    private string $findOutMoreUrl;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $picture;

    /**
     * @var Collection<int, Tag>
     *
     * @ORM\ManyToMany(targetEntity=Tag::class, orphanRemoval=true)
     * @ORM\JoinTable(name="community_event_tag")
     */
    private Collection $tags;

    /**
     * @var Collection<int, Tag>
     *
     * @ORM\ManyToMany(targetEntity=Tag::class, orphanRemoval=true)
     * @ORM\JoinTable(name="community_event_characterization_tag")
     */
    private Collection $characterizationTags;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $published = false;

    /**
     * @param Tag[] $tags
     * @param Tag[] $characterizationTags
     */
    public function __construct(
        Community $community,
        string $name,
        EventType $eventType,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate,
        string $registerUrl,
        string $findOutMoreUrl,
        array $tags,
        array $characterizationTags
    ) {
        $this->community = $community;
        $this->name = $name;
        $this->eventType = $eventType;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->registerUrl = $registerUrl;
        $this->findOutMoreUrl = $findOutMoreUrl;
        $this->tags = new ArrayCollection($tags);
        $this->characterizationTags = new ArrayCollection($characterizationTags);

        $community->getEvents()->add($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEventType(): EventType
    {
        return $this->eventType;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getRegisterUrl(): string
    {
        return $this->registerUrl;
    }

    public function getFindOutMoreUrl(): string
    {
        return $this->findOutMoreUrl;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getCharacterizationTags(): Collection
    {
        return $this->characterizationTags;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    public function update(
        string $name,
        EventType $eventType,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate,
        string $registerUrl,
        string $findOutMoreUrl,
        array $tags,
        array $characterizationTags,
    ): void {
        $this->name = $name;
        $this->eventType = $eventType;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->registerUrl = $registerUrl;
        $this->findOutMoreUrl = $findOutMoreUrl;

        $this->tags->clear();
        $this->characterizationTags->clear();

        foreach ($tags as $tag) {
            $this->getTags()->add($tag);
        }

        foreach ($characterizationTags as $tag) {
            $this->getCharacterizationTags()->add($tag);
        }
    }
}
