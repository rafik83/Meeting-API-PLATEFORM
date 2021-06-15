<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Application\Card\Provider\SortedByName;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Application\Card\EventCard;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName\EventCardProvider;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityEventRepositoryInterface;

class EventCardProviderTest extends TestCase
{
    use ProphecyTrait;

    public function testGetCards(): void
    {
        $repository = $this->prophesize(CommunityEventRepositoryInterface::class);

        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());

        $cardList = new CardList(
            $community->reveal(),
            'Title',
            [CardType::get(CardType::EVENT)],
            Sorting::get(Sorting::ALPHABETICAL)
        );

        $event = $this->prophesize(Event::class);

        $repository
            ->getSortedByName($community->reveal(), $cardList->getLimit())
            ->willReturn([$event->reveal()])
        ;

        $provider = new EventCardProvider($repository->reveal());

        $cards = $provider->getCards($cardList);

        self::assertEquals([new EventCard($event->reveal())], $cards);
    }

    /**
     * @dataProvider provideTestSupports
     */
    public function testSupports(CardList $cardList, bool $expectedResult): void
    {
        $repository = $this->prophesize(CommunityEventRepositoryInterface::class);

        $provider = new EventCardProvider($repository->reveal());

        self::assertEquals($expectedResult, $provider->supports($cardList));
    }

    public function provideTestSupports(): iterable
    {
        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());

        yield 'valid' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::EVENT)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            true,
        ];

        yield 'wrong sorting' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::EVENT)],
                Sorting::get(Sorting::DATE)
            ),
            false,
        ];

        yield 'too many object' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::EVENT), CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            false,
        ];

        yield 'everything wrong' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::EVENT), CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::DATE)
            ),
            false,
        ];
    }
}
