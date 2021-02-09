<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Repository;

use Proximum\Vimeet365\Domain\Entity\Member;

interface MemberRepositoryInterface
{
    public function add(Member $account): void;
}
