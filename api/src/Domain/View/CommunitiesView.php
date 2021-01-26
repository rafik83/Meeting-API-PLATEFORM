<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\View;

class CommunitiesView
{
    /**
     * @var CommunityView[]
     */
    public array $collection;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }
}
