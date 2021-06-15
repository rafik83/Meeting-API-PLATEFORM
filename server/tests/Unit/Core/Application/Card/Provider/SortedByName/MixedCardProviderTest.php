<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Application\Card\Provider\SortedByName;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName\CompanyCardProvider;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName\EventCardProvider;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName\MemberCardProvider;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName\MixedCardProvider;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Card;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community;

class MixedCardProviderTest extends TestCase
{
    use ProphecyTrait;

    public function testGetCards(): void
    {
        $memberCardProvider = $this->prophesize(MemberCardProvider::class);
        $companyCardProvider = $this->prophesize(CompanyCardProvider::class);
        $eventCardProvider = $this->prophesize(EventCardProvider::class);
        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());

        $provider = new MixedCardProvider(
            $memberCardProvider->reveal(),
            $companyCardProvider->reveal(),
            $eventCardProvider->reveal()
        );

        $cardList = new CardList(
            $community->reveal(),
            'Title',
            [CardType::get(CardType::COMPANY), CardType::get(CardType::MEMBER)],
            Sorting::get(Sorting::ALPHABETICAL)
        );

        $cardA = $this->prophesize(Card::class);
        $cardA->getName()->willReturn('A');

        $cardB = $this->prophesize(Card::class);
        $cardB->getName()->willReturn('B');

        $cardC = $this->prophesize(Card::class);
        $cardC->getName()->willReturn('C');

        $cardD = $this->prophesize(Card::class);
        $cardD->getName()->willReturn('D');

        $memberCardProvider->getCards($cardList)->willReturn([$cardA->reveal(), $cardD->reveal()]);
        $companyCardProvider->getCards($cardList)->willReturn([$cardC->reveal(), $cardB->reveal()]);

        $cards = $provider->getCards($cardList);

        self::assertEquals(['A', 'B', 'C', 'D'], array_map(fn (Card $card) => $card->getName(), $cards));
    }

    /**
     * @dataProvider provideTestSupports
     */
    public function testSupports(CardList $cardList, bool $expectedResult): void
    {
        $memberCardProvider = $this->prophesize(MemberCardProvider::class);
        $companyCardProvider = $this->prophesize(CompanyCardProvider::class);
        $eventCardProvider = $this->prophesize(EventCardProvider::class);

        $provider = new MixedCardProvider(
            $memberCardProvider->reveal(),
            $companyCardProvider->reveal(),
            $eventCardProvider->reveal()
        );

        self::assertEquals($expectedResult, $provider->supports($cardList));
    }

    public function provideTestSupports(): iterable
    {
        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());

        yield 'only 1 object type' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::COMPANY)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            false,
        ];

        yield 'wrong sorting' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::COMPANY)],
                Sorting::get(Sorting::DATE)
            ),
            false,
        ];

        yield 'valid partial' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::COMPANY), CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            true,
        ];

        yield 'valid with all' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::COMPANY), CardType::get(CardType::MEMBER), CardType::get(CardType::EVENT)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            true,
        ];
    }
}
