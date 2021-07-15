<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
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

        $cardList = new CardList(
            $command->getCommunity(),
            $command->title,
            $command->cardTypes,
            $command->sorting,
            $command->position,
            $command->limit
        );

        foreach ($command->configs as $type => $dto) {
            if ($type === CardType::MEMBER && $dto instanceof MemberConfigDto) {
                $cardList->addConfig(new CardList\MemberConfig($cardList, $dto->mainGoal));
            }
        }

        foreach ($command->tags as $dto) {
            if ($dto->tag === null) {
                continue;
            }
            new CardList\Tag($cardList, $dto->tag, $dto->position);
        }

        if ($command->published) {
            $cardList->publish();
        }

        $this->cardListRepository->add($cardList);
    }
}
