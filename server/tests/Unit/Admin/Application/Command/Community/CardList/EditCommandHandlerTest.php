<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\CardList;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\EditCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\EditCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList\Tag;
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
        $limit = 10;
        $cardListTagA = $this->prophesize(Tag::class);
        $tagA = $this->prophesize(\Proximum\Vimeet365\Core\Domain\Entity\Tag::class);
        $cardListTagA->getTag()->willReturn($tagA->reveal());
        $cardListTagA->getPosition()->willReturn(null);
        $cardListTagB = $this->prophesize(Tag::class);
        $tagB = $this->prophesize(\Proximum\Vimeet365\Core\Domain\Entity\Tag::class);
        $cardListTagB->getTag()->willReturn($tagB->reveal());
        $cardListTagB->getPosition()->willReturn(null);
        $tags = [$cardListTagA->reveal(), $cardListTagB->reveal()];

        $cardList = $this->prophesize(CardList::class);
        $cardList->getSorting()->willReturn($sorting);
        $cardList->getPosition()->willReturn($position);
        $cardList->getLimit()->willReturn($limit);
        $cardList->getTitle()->willReturn($cardListTitle);
        $cardList->getCardTypes()->willReturn($cardTypes);
        $cardList->getTags()->willReturn(new ArrayCollection($tags));
        $cardList->isPublished()->willReturn(false);
        $cardList->getConfig(CardType::get(CardType::MEMBER))->willReturn(null);
        $cardList->getConfig(CardType::get(CardType::COMPANY))->willReturn(null);
        $cardList->getConfig(CardType::get(CardType::EVENT))->willReturn(null);
        $cardList->getConfig(CardType::get(CardType::MEDIA))->willReturn(null);
        $cardList->removeConfig(CardType::get(CardType::MEMBER))->shouldBeCalled();
        $cardList->removeConfig(CardType::get(CardType::COMPANY))->shouldBeCalled();
        $cardList->removeConfig(CardType::get(CardType::EVENT))->shouldBeCalled();
        $cardList->removeConfig(CardType::get(CardType::MEDIA))->shouldBeCalled();

        $community = $this->prophesize(Community::class);
        $cardList->getCommunity()->willReturn($community->reveal());

        $cardList->update($position, $sorting, $cardTypes, $cardListTitle, $limit)->shouldBeCalled();

        $cardList->publish()->shouldBeCalled();
        $cardList->setTags(new ArrayCollection())->shouldBeCalled();

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
        $limit = 10;

        $cardList = $this->prophesize(CardList::class);
        $cardList->getSorting()->willReturn($sorting);
        $cardList->getPosition()->willReturn($position);
        $cardList->getLimit()->willReturn($limit);
        $cardList->getTitle()->willReturn($cardListTitle);
        $cardList->getCardTypes()->willReturn($cardTypes);
        $cardList->getTags()->willReturn(new ArrayCollection([]));
        $cardList->isPublished()->willReturn(true);
        $cardList->getConfig(CardType::get(CardType::MEMBER))->willReturn(null);
        $cardList->getConfig(CardType::get(CardType::COMPANY))->willReturn(null);
        $cardList->getConfig(CardType::get(CardType::EVENT))->willReturn(null);
        $cardList->getConfig(CardType::get(CardType::MEDIA))->willReturn(null);
        $cardList->removeConfig(CardType::get(CardType::MEMBER))->shouldBeCalled();
        $cardList->removeConfig(CardType::get(CardType::COMPANY))->shouldBeCalled();
        $cardList->removeConfig(CardType::get(CardType::EVENT))->shouldBeCalled();
        $cardList->removeConfig(CardType::get(CardType::MEDIA))->shouldBeCalled();
        $community = $this->prophesize(Community::class);
        $cardList->getCommunity()->willReturn($community->reveal());

        $cardList->update($position, $sorting, $cardTypes, $cardListTitle, $limit)->shouldBeCalled();

        $cardList->unpublish()->shouldBeCalled();
        $cardList->setTags(new ArrayCollection())->shouldBeCalled();

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
