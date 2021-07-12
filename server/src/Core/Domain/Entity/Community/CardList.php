<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList\Tag;
use Proximum\Vimeet365\Core\Domain\Entity\Tag as CoreTag;

/**
 * @ORM\Entity()
 * @ORM\Table(name="community_card_list")
 */
class CardList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class, inversedBy="cardLists")
     */
    private Community $community;

    /**
     * @ORM\Column
     */
    private string $title;

    /**
     * @var CardType[]
     *
     * @ORM\Column(type="card_list_card_types", nullable=true)
     */
    private array $cardTypes;

    /**
     * @ORM\Column(type="card_list_sorting")
     */
    private Sorting $sorting;

    /**
     * @ORM\Column(type="smallint")
     */
    public int $position = 0;

    /**
     * @ORM\Column(type="boolean", options={"default"= false})
     */
    public bool $published = false;

    /**
     * @var Collection<int, Tag>
     *
     * @ORM\OneToMany(targetEntity=Tag::class, orphanRemoval=true, mappedBy="cardList", cascade={"persist"})
     */
    private Collection $tags;

    /**
     * @param CardType[] $cardTypes
     */
    public function __construct(
        Community $community,
        string $title,
        array $cardTypes,
        Sorting $sorting,
        int $position = 0
    ) {
        $this->community = $community;
        $this->title = $title;
        $this->cardTypes = $cardTypes;
        $this->sorting = $sorting;
        $this->position = $position;
        $this->tags = new ArrayCollection();

        $this->community->getCardLists()->add($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return CardType[]
     */
    public function getCardTypes(): array
    {
        return $this->cardTypes;
    }

    public function getSorting(): Sorting
    {
        return $this->sorting;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function publish(): void
    {
        $this->published = true;
    }

    public function unpublish(): void
    {
        $this->published = false;
    }

    public function getLimit(): int
    {
        return 10;
    }

    /**
     * @param Collection<int, Tag> $tags
     */
    public function setTags(Collection $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @var CardType[]
     */
    public function update(int $position, Sorting $sorting, array $cardTypes, string $title): void
    {
        $this->position = $position;
        $this->sorting = $sorting;
        $this->cardTypes = $cardTypes;
        $this->title = $title;
    }

    public function match(?Member $member = null): bool
    {
        if ($member === null || $this->tags->isEmpty()) {
            return $this->tags->isEmpty();
        }

        $mainGoal = $member->getMainGoals()->first();
        if ($mainGoal === false) {
            return false;
        }

        $cardListTag = $this->getCardListTag($mainGoal->getTag());

        return $cardListTag !== null;
    }

    public function getPositionForMember(?Member $member): int
    {
        if ($member === null) {
            return $this->getPosition();
        }

        /** @var Community\Member\Goal|false $mainGoal */
        $mainGoal = $member->getMainGoals()->first();
        if ($mainGoal === false) {
            return $this->getPosition();
        }

        $cardListTag = $this->getCardListTag($mainGoal->getTag());

        return $cardListTag?->getPosition() ?? $this->getPosition();
    }

    public function getCardListTag(CoreTag $tag): ?Tag
    {
        $found = $this->tags->filter(fn (Tag $cardListTag): bool => $cardListTag->getTag()->getId() === $tag->getId())->first();
        if ($found === false) {
            return null;
        }

        return $found;
    }
}
