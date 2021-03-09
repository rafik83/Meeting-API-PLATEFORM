<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Domain\Entity\Tag;

class TagView
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create(Tag $tag): self
    {
        return new self((int) $tag->getId(), (string) $tag->getLabel());
    }

    public static function createFromNomenclatureTag(NomenclatureTag $tag): self
    {
        return new self((int) $tag->getTag()->getId(), (string) $tag->getLabel());
    }
}
