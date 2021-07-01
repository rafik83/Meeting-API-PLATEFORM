<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

/**
 * @ORM\Entity
 * @ORM\Table(name="community_member")
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
     * @ORM\OneToMany(targetEntity=Goal::class, mappedBy="member", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"priority" = "ASC"})
     *
     * @var Collection<int, Goal>
     */
    private Collection $goals;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $joinedAt;

    public function __construct(Community $community, Account $account, ?\DateTimeImmutable $joinedAt = null)
    {
        $this->community = $community;
        $this->account = $account;
        $this->goals = new ArrayCollection();

        $this->joinedAt = $joinedAt ?? new \DateTimeImmutable();

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

    /**
     * @return Collection<int, Goal>
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function hasGoal(Community\Goal $communityGoal, Tag $tag): bool
    {
        return $this->goals->exists(
            fn (int $index, Goal $goal) => $goal->getTag()->getId() === $tag->getId() && $goal->getCommunityGoal()->getId() === $communityGoal->getId()
        );
    }

    public function getJoinedAt(): \DateTimeImmutable
    {
        return $this->joinedAt;
    }

    /**
     * @return Collection<int, Goal>
     */
    public function getMainGoals(): Collection
    {
        $data = $this->getGoals()
            ->filter(fn (Goal $goal) => $goal->getCommunityGoal()->getParent() === null)
            ->getValues()
        ;

        return new ArrayCollection($data);
    }

    /**
     * @return Collection<int, Goal>
     */
    public function getRefinedGoals(Goal $mainGoal): Collection
    {
        $data = $this->getGoals()
            ->filter(fn (Goal $goal) => $goal->getCommunityGoal()->getParent()?->getId() === $mainGoal->getCommunityGoal()->getId())
            ->filter(fn (Goal $goal) => $goal->getPriority() !== null)
            ->getValues()
        ;

        return new ArrayCollection($data);
    }
}
