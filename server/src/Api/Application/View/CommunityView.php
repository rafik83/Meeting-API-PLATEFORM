<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View;

class CommunityView
{
    public int $id;

    public string $name;

    /** @var NomenclatureView[] */
    public array $nomenclatures;

    /**
     * @param NomenclatureView[] $nomenclatures
     */
    public function __construct(int $id, string $name, array $nomenclatures)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nomenclatures = $nomenclatures;
    }
}
