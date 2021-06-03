<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Application\Card\Provider\SortedByDate;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByDate\CompanyCardProvider;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByDate\MemberCardProvider;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByDate\MixedCardProvider;
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
        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());
        $provider = new MixedCardProvider($memberCardProvider->reveal(), $companyCardProvider->reveal());

        $cardList = new CardList(
            $community->reveal(),
            'Title',
            [CardType::get(CardType::COMPANY), CardType::get(CardType::MEMBER)],
            Sorting::get(Sorting::ALPHABETICAL)
        );

        $cardA = $this->prophesize(Card::class);
        $cardA->getDate()->willReturn(new \DateTimeImmutable('2021-01-01'));

        $cardB = $this->prophesize(Card::class);
        $cardB->getDate()->willReturn(new \DateTimeImmutable('2021-01-02'));

        $cardC = $this->prophesize(Card::class);
        $cardC->getDate()->willReturn(new \DateTimeImmutable('2021-01-03'));

        $cardD = $this->prophesize(Card::class);
        $cardD->getDate()->willReturn(new \DateTimeImmutable('2021-01-04'));

        $memberCardProvider->getCards($cardList)->willReturn([$cardA->reveal(), $cardD->reveal()]);
        $companyCardProvider->getCards($cardList)->willReturn([$cardC->reveal(), $cardB->reveal()]);

        $cards = $provider->getCards($cardList);

        self::assertEquals(
            ['2021-01-01', '2021-01-02', '2021-01-03', '2021-01-04'],
            array_map(static fn (Card $card) => $card->getDate()->format('Y-m-d'), $cards)
        );
    }

    /**
     * @dataProvider provideTestSupports
     */
    public function testSupports(CardList $cardList, bool $expectedResult): void
    {
        $memberCardProvider = $this->prophesize(MemberCardProvider::class);
        $companyCardProvider = $this->prophesize(CompanyCardProvider::class);

        $provider = new MixedCardProvider($memberCardProvider->reveal(), $companyCardProvider->reveal());

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
                Sorting::get(Sorting::DATE)
            ),
            false,
        ];

        yield 'wrong sorting' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::COMPANY)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            false,
        ];

        yield 'valid' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::COMPANY), CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::DATE)
            ),
            true,
        ];
    }
}
