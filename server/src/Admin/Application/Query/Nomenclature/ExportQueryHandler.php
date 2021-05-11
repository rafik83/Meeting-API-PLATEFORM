<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Query\Nomenclature;

use Proximum\Vimeet365\Core\Application\Nomenclature\Exporter;

class ExportQueryHandler
{
    private Exporter $exporter;

    public function __construct(Exporter $exporter)
    {
        $this->exporter = $exporter;
    }

    public function __invoke(ExportQuery $command): \SplFileObject
    {
        $output = new \SplTempFileObject();

        $this->exporter->export($command->nomenclature, $output);

        $output->rewind();

        return $output;
    }
}
