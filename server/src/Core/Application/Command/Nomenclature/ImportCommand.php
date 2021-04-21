<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Command\Nomenclature;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;

class ImportCommand
{
    public Nomenclature $nomenclature;
    public \SplFileObject $file;

    public function __construct(Nomenclature $nomenclature, \SplFileObject $file)
    {
        $this->nomenclature = $nomenclature;
        $this->file = $file;
    }
}
