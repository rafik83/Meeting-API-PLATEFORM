<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Domain\Entity\Community\Step;
use Proximum\Vimeet365\Domain\Entity\Member\MemberTag;

/**
 * @ORM\Entity
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="members")
     * @ORM\JoinColumn(nullable=false)
     */
    private Account $account;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class, inversedBy="members")
     * @ORM\JoinColumn(nullable=false)
     */
    private Community $community;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $joinedAt;

    /**
     * @ORM\OneToMany(targetEntity=MemberTag::class, mappedBy="member", cascade="ALL", orphanRemoval=true)
     * @ORM\OrderBy({"priority" = "ASC"})
     *
     * @var Collection<int, MemberTag>
     */
    private Collection $tags;

    /**
     * @ORM\ManyToOne(targetEntity=Step::class)
     */
    private ?Step $currentQualificationStep;

    public function __construct(Community $community, Account $account, ?\DateTimeImmutable $joinedAt = null)
    {
        $this->community = $community;
        $this->account = $account;
        $this->tags = new ArrayCollection();

        $this->joinedAt = $joinedAt ?? new \DateTimeImmutable();
        $firstStep = $this->community->getSteps()->first();
        $this->currentQualificationStep = $firstStep !== false ? $firstStep : null;

        $account->getMembers()->add($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }

    public function getJoinedAt(): \DateTimeImmutable
    {
        return $this->joinedAt;
    }

    /**
     * @return Collection<int, MemberTag>
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTagsByNomenclature(Nomenclature $nomenclature): Collection
    {
        return $this->getMemberTagsByNomenclature($nomenclature)
            ->map(fn (MemberTag $tag): Tag => $tag->getTag())
        ;
    }

    /**
     * @return Collection<int, MemberTag>
     */
    public function getMemberTagsByNomenclature(Nomenclature $nomenclature): Collection
    {
        return $this->tags
            ->filter(fn (MemberTag $memberTag): bool => $memberTag->getNomenclature() === $nomenclature)
        ;
    }

    /**
     * @param Tag[] $tags sorted by priority
     */
    public function replaceTagsByNomenclature(Nomenclature $nomenclature, array $tags): void
    {
        $tagIds = array_map(static fn (Tag $tag): int => (int) $tag->getId(), $tags);

        $tagToRemove = $this->tags
            ->filter(fn (MemberTag $memberTag): bool => $memberTag->getNomenclature() === $nomenclature)
            ->filter(fn (MemberTag $memberTag): bool => !\in_array($memberTag->getTag()->getId(), $tagIds, true))
        ;

        foreach ($tagToRemove as $tag) {
            $this->tags->removeElement($tag);
        }

        foreach ($tags as $priority => $tag) {
            $this->addTag($nomenclature, $tag, $priority);
        }
    }

    public function addTag(Nomenclature $nomenclature, Tag $tag, int $priority): void
    {
        $found = $this->tags->filter(
            fn (MemberTag $memberTag): bool => $memberTag->getNomenclature()->getId() === $nomenclature->getId()
                && $memberTag->getTag()->getId() === $tag->getId()
        )->first();

        if ($found !== false) {
            $found->setPriority($priority);

            return;
        }

        $this->tags->add(new MemberTag($this, $nomenclature, $tag, $priority));
    }

    public function removeTag(Nomenclature $nomenclature, Tag $tag): void
    {
        $element = $this->tags->filter(
            fn (MemberTag $memberTag): bool => $memberTag->getTag() === $tag && $memberTag->getNomenclature() === $nomenclature
        )->first();

        if ($element === false) {
            return;
        }

        $this->tags->removeElement($element);
    }

    public function getCurrentQualificationStep(): ?Step
    {
        return $this->currentQualificationStep;
    }

    public function setCurrentQualificationStep(?Step $step): void
    {
        $this->currentQualificationStep = $step;
    }
}
