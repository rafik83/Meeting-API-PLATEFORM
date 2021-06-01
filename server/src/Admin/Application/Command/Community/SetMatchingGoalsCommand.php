<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community;

use Proximum\Vimeet365\Admin\Application\Dto\Community\MatchingGoalDto;
use Proximum\Vimeet365\Admin\Infrastructure\Validator as AssertVimeet365;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Community\GoalMatching;
use Symfony\Component\Validator\Constraints as Assert;

class SetMatchingGoalsCommand
{
    private Goal $mainGoal;

    /**
     * @var MatchingGoalDto[]
     *
     * @Assert\Valid
     * @AssertVimeet365\GoalMatching\MatchUniqueness
     */
    public array $matchingTags = [];

    public function __construct(Goal $mainGoal)
    {
        $this->mainGoal = $mainGoal;
        $this->matchingTags = $mainGoal->getMatching()
            ->map(fn (GoalMatching $matching) => MatchingGoalDto::createFromGoalMatching($matching))
            ->getValues()
        ;
    }

    public function getMainGoal(): Goal
    {
        return $this->mainGoal;
    }
}
