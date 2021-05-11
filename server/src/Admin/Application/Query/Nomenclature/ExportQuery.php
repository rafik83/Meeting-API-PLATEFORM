<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Query\Nomenclature;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;

class ExportQuery
{
    public Nomenclature $nomenclature;

    public function __construct(Nomenclature $nomenclature)
    {
        $this->nomenclature = $nomenclature;
    }
}
