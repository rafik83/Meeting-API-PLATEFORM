<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

use Proximum\Vimeet365\Domain\Entity\Community\Step;

class CommunityStepView
{
    public int $id;
    public NomenclatureView $nomenclature;
    public int $position;
    public string $title;
    public ?string $description;
    public int $min;
    public ?int $max;

    public function __construct(
        int $id,
        NomenclatureView $nomenclature,
        int $position,
        string $title,
        ?string $description,
        int $min = 0,
        ?int $max = null
    ) {
        $this->id = $id;
        $this->nomenclature = $nomenclature;
        $this->position = $position;
        $this->title = $title;
        $this->description = $description;
        $this->min = $min;
        $this->max = $max;
    }

    public static function create(Step $step): self
    {
        return new self(
            (int) $step->getId(),
            NomenclatureView::create($step->getNomenclature()),
            $step->getPosition(),
            $step->getTitle(),
            $step->getDescription(),
            $step->getMin(),
            $step->getMax(),
        );
    }
}
