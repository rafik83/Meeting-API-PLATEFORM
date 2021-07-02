<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;
use RuntimeException;

class CreateCommandHandler
{
    public function __construct(private CardListRepositoryInterface $cardListRepository)
    {
    }

    public function __invoke(CreateCommand $command): void
    {
        if (\is_null($command->sorting)) {
            throw new RuntimeException('Sorting must not be null');
        }

        $cardList = new CardList($command->getCommunity(), $command->title, $command->cardTypes, $command->sorting, $command->tags);

        if ($command->published) {
            $cardList->publish();
        }

        $this->cardListRepository->add($cardList);
    }
}
