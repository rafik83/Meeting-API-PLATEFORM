<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View;

class CommunityCardListView
{
    public function __construct(
        public int $id,
        public int $position,
        public string $title
    ) {
    }
}
