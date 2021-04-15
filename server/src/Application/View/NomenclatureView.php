<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

use Proximum\Vimeet365\Domain\Entity\Nomenclature;

class NomenclatureView
{
    public int $id;

    public string $reference;

    /** @var TagView[] */
    public array $tags;

    /**
     * @param TagView[] $tags
     */
    public function __construct(int $id, string $reference, array $tags = [])
    {
        $this->id = $id;
        $this->reference = $reference;
        $this->tags = $tags;
    }

    public static function create(Nomenclature $nomenclature): self
    {
        return new self(
            (int) $nomenclature->getId(),
            $nomenclature->getReference(),
            array_map(
                static fn (Nomenclature\NomenclatureTag $tag): TagView => TagView::createFromNomenclatureTag($tag),
                $nomenclature->getTags()->getValues()
            )
        );
    }
}
