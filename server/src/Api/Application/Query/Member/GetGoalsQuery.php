<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query\Member;

use Proximum\Vimeet365\Core\Domain\Entity\Member;

class GetGoalsQuery
{
    public Member $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}
