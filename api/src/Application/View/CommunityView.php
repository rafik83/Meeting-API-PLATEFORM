<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

class CommunityView
{
    public int $id;

    public string $name;

    /** @var NomenclatureView[] */
    public array $nomenclatures;

    /** @var CommunityStepView[] */
    public array $steps;

    /**
     * @param NomenclatureView[]  $nomenclatures
     * @param CommunityStepView[] $steps
     */
    public function __construct(int $id, string $name, array $nomenclatures, array $steps)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nomenclatures = $nomenclatures;
        $this->steps = $steps;
    }
}
