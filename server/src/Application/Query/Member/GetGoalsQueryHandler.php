<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Query\Member;

use Proximum\Vimeet365\Application\View\Goal\MemberGoalView;
use Proximum\Vimeet365\Domain\Entity\Community\Goal as CommunityGoal;

class GetGoalsQueryHandler
{
    /**
     * @return MemberGoalView[]
     */
    public function __invoke(GetGoalsQuery $query): array
    {
        $member = $query->member;
        $community = $member->getCommunity();

        $goals = $community->getGoals()->map(
            fn (CommunityGoal $goal): MemberGoalView => new MemberGoalView($goal, $member)
        )->getValues();

        return $goals;
    }
}
