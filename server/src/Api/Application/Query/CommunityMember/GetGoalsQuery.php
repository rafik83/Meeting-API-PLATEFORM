<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query\CommunityMember;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;

class GetGoalsQuery
{
    public Member $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}
