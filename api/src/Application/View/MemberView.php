<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

class MemberView
{
    public int $id;
    public \DateTimeImmutable $joinedAt;

    public function __construct(int $id, \DateTimeImmutable $joinedAt)
    {
        $this->id = $id;
        $this->joinedAt = $joinedAt;
    }
}
