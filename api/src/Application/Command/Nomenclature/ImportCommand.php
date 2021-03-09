<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Nomenclature;

use Proximum\Vimeet365\Domain\Entity\Nomenclature;

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
