<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

use Proximum\Vimeet365\Domain\Entity\Tag;

class MemberTagView
{
    public int $id;
    public string $name;
    public int $priority;

    public function __construct(int $id, string $name, int $priority)
    {
        $this->id = $id;
        $this->name = $name;
        $this->priority = $priority;
    }

    public static function create(Tag $tag, int $priority = 0): self
    {
        return new self((int) $tag->getId(), (string) $tag->getLabel(), $priority);
    }
}
