<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Nomenclature;

class EditCommandHandler
{
    public function __invoke(EditCommand $command): void
    {
        $nomenclature = $command->nomenclature;

        $nomenclature->setReference($command->reference);
    }
}
