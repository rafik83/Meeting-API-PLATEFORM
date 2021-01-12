<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Query\Community;

class CommunityViewQuery
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
