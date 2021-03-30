<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Command\Nomenclature;

use Proximum\Vimeet365\Core\Application\Nomenclature\Importer;

class ImportCommandHandler
{
    private Importer $importer;

    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }

    public function __invoke(ImportCommand $command): void
    {
        $this->importer->import($command->nomenclature, $command->file);
    }
}
