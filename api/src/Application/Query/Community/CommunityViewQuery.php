<?php

namespace Proximum\Vimeet365\Application\Query\Community;

use Proximum\Vimeet365\Application\Query\Query;

class CommunityViewQuery implements Query
{
    public int $id;

    public function __construct(int $id) {
        $this->id = $id;
    }
}
