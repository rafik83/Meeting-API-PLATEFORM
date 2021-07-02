<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

class EditCommandHandler
{
    public function __invoke(EditCommand $command): CardList
    {
        $cardList = $command->cardList;

        $cardList->update($command->position, $command->sorting, $command->cardTypes, $command->title, $command->tags);

        if ($cardList->isPublished() && !$command->published) {
            $cardList->unpublish();
        }

        if (!$cardList->isPublished() && $command->published) {
            $cardList->publish();
        }

        return $cardList;
    }
}
