<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community;

class EditCommandHandler
{
    public function __invoke(EditCommand $command): void
    {
        $community = $command->getCommunity();

        $community->update(
            $command->name,
            $command->defaultLanguage,
            $command->languages,
            $command->skillNomenclature,
            $command->eventNomenclature
        );
    }
}
