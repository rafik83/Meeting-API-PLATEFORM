<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View\Goal;

use Proximum\Vimeet365\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Domain\Entity\Member;

class MemberGoalView
{
    public CommunityGoalView $goal;

    /** @var MemberGoalTagView[] */
    public array $tags;

    public function __construct(Goal $goal, Member $member)
    {
        $this->goal = new CommunityGoalView($goal);
        $this->tags = $member->getGoals()
            ->filter(
                fn (Member\Goal $memberGoal): bool => $memberGoal->getGoal()->getId() === $goal->getId()
            )
            ->map(
                fn (Member\Goal $memberGoal): MemberGoalTagView => new MemberGoalTagView($memberGoal->getTag(), $memberGoal->getPriority())
            )
            ->getValues()
        ;
    }
}
