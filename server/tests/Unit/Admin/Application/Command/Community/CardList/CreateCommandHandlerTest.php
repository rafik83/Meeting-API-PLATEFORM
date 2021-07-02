<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\CardList;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\CreateCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\CreateCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;

class CreateCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testEmptyTagsArray(): void
    {
        $cardListTitle = 'Dummy Title';
        $community = new Community('Dummy Community');
        $cardList = new CardList($community, $cardListTitle, [], Sorting::get(Sorting::ALPHABETICAL));
        $cardListRepository = $this->prophesize(CardListRepositoryInterface::class);
        $cardListRepository->add($cardList)->shouldBeCalledOnce();

        $command = new CreateCommand($community);
        $command->sorting = Sorting::get(Sorting::ALPHABETICAL);
        $command->cardTypes = [];
        $command->title = $cardListTitle;

        $handler = new CreateCommandHandler($cardListRepository->reveal());
        $handler($command);
    }

    public function testShouldThrowRunTimeException(): void
    {
        $this->expectException(\RuntimeException::class);

        $cardListTitle = 'Dummy Title';
        $community = new Community('Dummy Community');
        $cardList = new CardList($community, $cardListTitle, [], Sorting::get(Sorting::ALPHABETICAL));
        $cardListRepository = $this->prophesize(CardListRepositoryInterface::class);
        $cardListRepository->add($cardList)->shouldNotBeCalled();

        $command = new CreateCommand($community);
        $command->sorting = null;
        $command->cardTypes = [];
        $command->title = $cardListTitle;

        $handler = new CreateCommandHandler($cardListRepository->reveal());
        $handler($command);
    }

    public function testWithTags(): void
    {
        $tagA = $this->prophesize(Tag::class);
        $tagA->getId()->willReturn(1);
        $tagB = $this->prophesize(Tag::class);
        $tagB->getId()->willReturn(2);
        $tags = [$tagA->reveal(), $tagB->reveal()];

        $cardListTitle = 'Dummy Title';
        $community = new Community('Dummy Community');
        $cardList = new CardList($community, $cardListTitle, [], Sorting::get(Sorting::ALPHABETICAL), $tags);
        $cardListRepository = $this->prophesize(CardListRepositoryInterface::class);
        $cardListRepository->add($cardList)->shouldBeCalledOnce();

        $command = new CreateCommand($community);
        $command->sorting = Sorting::get(Sorting::ALPHABETICAL);
        $command->cardTypes = [];
        $command->title = $cardListTitle;
        $command->tags = $tags;

        $handler = new CreateCommandHandler($cardListRepository->reveal());
        $handler($command);
    }
}
