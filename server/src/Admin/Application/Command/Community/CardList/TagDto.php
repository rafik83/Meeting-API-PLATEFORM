<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Tag;

class TagDto
{
    public ?Tag $tag;

    public ?int $position;

    public function __construct(?Tag $tag = null, ?int $position = null)
    {
        $this->tag = $tag;
        $this->position = $position;
    }
}
