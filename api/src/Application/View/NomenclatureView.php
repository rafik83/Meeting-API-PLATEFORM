<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

use Proximum\Vimeet365\Domain\Entity\Nomenclature;

class NomenclatureView
{
    public int $id;

    public string $name;

    /** @var NomenclatureTagView[] */
    public array $tags;

    /**
     * @param NomenclatureTagView[] $tags
     */
    public function __construct(int $id, string $name, array $tags = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->tags = $tags;
    }

    public static function create(Nomenclature $nomenclature): self
    {
        return new self(
            (int) $nomenclature->getId(),
            $nomenclature->getName(),
            array_map(
                static fn (Nomenclature\NomenclatureTag $tag): NomenclatureTagView => new NomenclatureTagView(
                    $tag->getTag(),
                    $tag->getParent() !== null ? $tag->getParent()->getTag() : null
                ),
                $nomenclature->getTags()->getValues()
            )
        );
    }
}
