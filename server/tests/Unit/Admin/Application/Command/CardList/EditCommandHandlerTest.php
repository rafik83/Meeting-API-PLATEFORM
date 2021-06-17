<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\CardList;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\CardList\EditCommand;
use Proximum\Vimeet365\Admin\Application\Command\CardList\EditCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;

class EditCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testShouldPublish(): void
    {
        $cardListTitle = 'Dummy Title';
        $cardTypes = [CardType::get(CardType::COMPANY)];
        $sorting = Sorting::get(Sorting::ALPHABETICAL);
        $position = 0;

        $cardList = $this->prophesize(CardList::class);
        $cardList->getSorting()->willReturn($sorting);
        $cardList->getPosition()->willReturn($position);
        $cardList->getTitle()->willReturn($cardListTitle);
        $cardList->getCardTypes()->willReturn($cardTypes);
        $cardList->isPublished()->willReturn(false);

        $cardList->update($position, $sorting, $cardTypes, $cardListTitle)->shouldBeCalled();

        $cardList->publish()->shouldBeCalled();

        $cardListRepository = $this->prophesize(CardListRepositoryInterface::class);

        $published = true;

        $command = new EditCommand($cardList->reveal());
        $command->position = $position;
        $command->published = $published;
        $command->sorting = $sorting;

        $handler = new EditCommandHandler($cardListRepository->reveal());
        $handler($command);
    }

    public function testShouldUnpublish(): void
    {
        $cardListTitle = 'Dummy Title';
        $cardTypes = [CardType::get(CardType::COMPANY)];
        $sorting = Sorting::get(Sorting::ALPHABETICAL);
        $position = 0;

        $cardList = $this->prophesize(CardList::class);
        $cardList->getSorting()->willReturn($sorting);
        $cardList->getPosition()->willReturn($position);
        $cardList->getTitle()->willReturn($cardListTitle);
        $cardList->getCardTypes()->willReturn($cardTypes);
        $cardList->isPublished()->willReturn(true);

        $cardList->update($position, $sorting, $cardTypes, $cardListTitle)->shouldBeCalled();

        $cardList->unpublish()->shouldBeCalled();

        $cardListRepository = $this->prophesize(CardListRepositoryInterface::class);

        $published = false;

        $command = new EditCommand($cardList->reveal());
        $command->position = $position;
        $command->published = $published;
        $command->sorting = $sorting;

        $handler = new EditCommandHandler($cardListRepository->reveal());
        $handler($command);
    }
}
