<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Member;

use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal as CommunityGoal;
use Proximum\Vimeet365\Core\Domain\Entity\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

/**
 * @ORM\Entity()
 * @ORM\Table(name="member_goal")
 */
class Goal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="goals")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Member $member;

    /**
     * @ORM\ManyToOne(targetEntity=CommunityGoal::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private CommunityGoal $communityGoal;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Tag $tag;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $priority;

    public function __construct(Member $member, CommunityGoal $communityGoal, Tag $tag, ?int $priority)
    {
        $this->member = $member;
        $this->communityGoal = $communityGoal;
        $this->tag = $tag;
        $this->priority = $priority;

        $this->member->getGoals()->add($this);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getCommunityGoal(): CommunityGoal
    {
        return $this->communityGoal;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }
}
