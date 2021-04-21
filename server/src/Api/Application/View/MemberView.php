<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View;

class MemberView
{
    public int $id;
    public \DateTimeImmutable $joinedAt;
    public int $community;

    public function __construct(int $id, \DateTimeImmutable $joinedAt, int $community)
    {
        $this->id = $id;
        $this->joinedAt = $joinedAt;
        $this->community = $community;
    }
}
