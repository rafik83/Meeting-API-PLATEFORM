<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;

use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

/**
 * @ORM\Entity()
 * @ORM\Table(name="community_goal_matching")
 */
class GoalMatching
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Goal::class, inversedBy="matching")
     */
    private Goal $goal;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Tag::class)
     */
    private Tag $from;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Tag::class)
     */
    private Tag $to;

    /**
     * @ORM\Column(type="integer", options={"default"=0})
     */
    private int $priority;

    public function __construct(Goal $goal, Tag $from, Tag $to, int $priority = 0)
    {
        $this->goal = $goal;
        $this->from = $from;
        $this->to = $to;
        $this->priority = $priority;

        $this->goal->getMatching()->add($this);
    }

    public function getGoal(): Goal
    {
        return $this->goal;
    }

    public function getFrom(): Tag
    {
        return $this->from;
    }

    public function getTo(): Tag
    {
        return $this->to;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function update(int $priority): void
    {
        $this->priority = $priority;
    }
}
