<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\CardList;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\EditCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\EditCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
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
        $tags = [$this->prophesize(Tag::class)->reveal(), $this->prophesize(Tag::class)->reveal()];

        $cardList = $this->prophesize(CardList::class);
        $cardList->getSorting()->willReturn($sorting);
        $cardList->getPosition()->willReturn($position);
        $cardList->getTitle()->willReturn($cardListTitle);
        $cardList->getCardTypes()->willReturn($cardTypes);
        $cardList->getTags()->willReturn(new ArrayCollection($tags));
        $cardList->isPublished()->willReturn(false);

        $cardList->update($position, $sorting, $cardTypes, $cardListTitle, $tags)->shouldBeCalled();

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
        $tags = [$this->prophesize(Tag::class)->reveal(), $this->prophesize(Tag::class)->reveal()];

        $cardList = $this->prophesize(CardList::class);
        $cardList->getSorting()->willReturn($sorting);
        $cardList->getPosition()->willReturn($position);
        $cardList->getTitle()->willReturn($cardListTitle);
        $cardList->getCardTypes()->willReturn($cardTypes);
        $cardList->getTags()->willReturn(new ArrayCollection([$tags]));
        $cardList->isPublished()->willReturn(true);

        $cardList->update($position, $sorting, $cardTypes, $cardListTitle, $tags)->shouldBeCalled();

        $cardList->unpublish()->shouldBeCalled();

        $cardListRepository = $this->prophesize(CardListRepositoryInterface::class);

        $published = false;

        $command = new EditCommand($cardList->reveal());
        $command->position = $position;
        $command->published = $published;
        $command->sorting = $sorting;
        $command->tags = $tags;

        $handler = new EditCommandHandler($cardListRepository->reveal());
        $handler($command);
    }
}
