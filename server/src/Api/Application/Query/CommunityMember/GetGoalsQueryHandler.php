<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query\CommunityMember;

use Proximum\Vimeet365\Api\Application\View\Goal\MemberGoalView;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal as CommunityGoal;

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
