<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View;

class CommunityListView
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
