<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;

class NomenclatureTagView
{
    public TagView $tag;
    public ?TagView $parent;

    public function __construct(NomenclatureTag $nomenclatureTag)
    {
        $parent = $nomenclatureTag->getParent();

        $this->tag = TagView::createFromNomenclatureTag($nomenclatureTag);
        $this->parent = $parent !== null ? TagView::createFromNomenclatureTag($parent) : null;
    }
}
