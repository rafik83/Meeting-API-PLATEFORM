<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

use Proximum\Vimeet365\Domain\Entity\Nomenclature;

class NomenclatureTagsView
{
    public NomenclatureView $nomenclature;

    /** @var MemberTagView[] */
    public array $tags;

    /**
     * @param MemberTagView[] $tags
     */
    public function __construct(Nomenclature $nomenclature, array $tags)
    {
        $this->nomenclature = NomenclatureView::create($nomenclature);
        $this->tags = $tags;
    }
}
