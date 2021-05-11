<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Nomenclature;

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
        if ($command->file === null) {
            throw new \RuntimeException('The validation should have catch this');
        }

        $input = new \SplFileObject((string) $command->file->getRealPath());

        $this->importer->import($command->nomenclature, $input);
    }
}
