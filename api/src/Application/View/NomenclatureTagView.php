<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

use Proximum\Vimeet365\Domain\Entity\Tag;

class NomenclatureTagView
{
    public TagView $tag;
    public ?TagView $parent;

    public function __construct(Tag $tag, ?Tag $parent)
    {
        $this->tag = TagView::create($tag);
        $this->parent = $parent !== null ? TagView::create($tag) : null;
    }
}
