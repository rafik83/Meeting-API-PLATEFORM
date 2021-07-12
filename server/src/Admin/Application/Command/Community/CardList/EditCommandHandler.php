<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Doctrine\Common\Collections\ArrayCollection;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

class EditCommandHandler
{
    public function __invoke(EditCommand $command): CardList
    {
        $cardList = $command->cardList;

        $cardList->update($command->position, $command->sorting, $command->cardTypes, $command->title);

        $cardList->setTags(new ArrayCollection());
        foreach ($command->tags as $dto) {
            if ($dto->tag === null) {
                continue;
            }
            new CardList\Tag($cardList, $dto->tag, $dto->position);
        }

        if ($cardList->isPublished() && !$command->published) {
            $cardList->unpublish();
        }

        if (!$cardList->isPublished() && $command->published) {
            $cardList->publish();
        }

        return $cardList;
    }
}
