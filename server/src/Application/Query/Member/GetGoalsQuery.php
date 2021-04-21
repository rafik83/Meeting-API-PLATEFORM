<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Query\Member;

use Proximum\Vimeet365\Domain\Entity\Member;

class GetGoalsQuery
{
    public Member $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}
