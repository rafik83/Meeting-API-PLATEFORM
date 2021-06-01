<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community;

use Proximum\Vimeet365\Admin\Application\Dto\Community\RefinedGoalDto;
use Proximum\Vimeet365\Admin\Infrastructure\Validator as AssertVimeet365;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Symfony\Component\Validator\Constraints as Assert;

class RefineMainGoalCommand
{
    private Goal $mainGoal;

    /**
     * @var RefinedGoalDto[]
     *
     * @Assert\Valid
     * @AssertVimeet365\RefinedGoalTagUniqueness
     */
    public array $refinedGoals = [];

    public function __construct(Goal $mainGoal)
    {
        $this->mainGoal = $mainGoal;

        $this->refinedGoals = $this->mainGoal->getChildren()
            ->map(fn (Goal $goal) => RefinedGoalDto::createFromGoal($goal))
            ->getValues()
        ;
    }

    public function getMainGoal(): Goal
    {
        return $this->mainGoal;
    }
}
