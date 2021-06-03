<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;

class EditCommandHandler
{
    public function __construct(private CardListRepositoryInterface $cardListRepository)
    {
    }

    public function __invoke(EditCommand $command): CardList
    {
        $cardList = $command->cardList;

        $cardList->update($command->position, $command->sorting, $command->cardTypes, $command->title);

        if ($cardList->isPublished() && !$command->published) {
            $cardList->unpublish();
        }

        if (!$cardList->isPublished() && $command->published) {
            $cardList->publish();
        }

        return $cardList;
    }
}
