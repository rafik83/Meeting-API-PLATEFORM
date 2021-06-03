<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\CardList;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\CardList\CreateCommand;
use Proximum\Vimeet365\Admin\Application\Command\CardList\CreateCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;

class CreateCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testEmpty(): void
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
}
