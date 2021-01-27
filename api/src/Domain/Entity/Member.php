<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\ManyToOne(targetEntity=Account::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Account $account;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Community $community;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $joinedAt;

    /**
     * @ORM\OneToMany(targetEntity=MemberTag::class, mappedBy="member", cascade="ALL")
     *
     * @var Collection<int, MemberTag>
     */
    private Collection $tags;

    public function __construct(Community $community, Account $account, ?\DateTimeImmutable $joinedAt = null)
    {
        $this->community = $community;
        $this->account = $account;
        $this->joinedAt = $joinedAt ?? new \DateTimeImmutable();
        $this->tags = new ArrayCollection();
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
        return $this->tags
            ->filter(fn (MemberTag $memberTag): bool => $memberTag->getNomenclature() === $nomenclature)
            ->map(fn (MemberTag $tag): Tag => $tag->getTag())
        ;
    }

    public function addTag(Nomenclature $nomenclature, Tag $tag): void
    {
        $this->tags->add(new MemberTag($this, $nomenclature, $tag));
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
}
