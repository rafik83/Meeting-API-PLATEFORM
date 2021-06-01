<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Dto\Community;

use Proximum\Vimeet365\Admin\Infrastructure\Validator as AssertVimeet365;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Community\GoalMatching;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\Validator\Constraints as Assert;

class MatchingGoalDto
{
    private Goal $goal;

    /**
     * @Assert\NotNull
     * @AssertVimeet365\TagBelongToNomenclature(nomenclaturePropertyPath="goal.nomenclature")
     */
    public ?Tag $from = null;

    /**
     * @Assert\NotNull
     * @AssertVimeet365\TagBelongToNomenclature(nomenclaturePropertyPath="goal.nomenclature")
     */
    public ?Tag $to = null;

    public function __construct(Goal $goal, ?Tag $from = null, ?Tag $to = null)
    {
        $this->goal = $goal;
        $this->from = $from;
        $this->to = $to;
    }

    public static function createFromGoalMatching(GoalMatching $matching): self
    {
        return new MatchingGoalDto($matching->getGoal(), $matching->getFrom(), $matching->getTo());
    }

    public function getGoal(): Goal
    {
        return $this->goal;
    }
}
