<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Application\Card\Provider\SortedByName;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Application\Card\MemberCard;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName\MemberCardProvider;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Repository\MemberRepositoryInterface;

class MemberCardProviderTest extends TestCase
{
    use ProphecyTrait;

    public function testGetCards(): void
    {
        $repository = $this->prophesize(MemberRepositoryInterface::class);

        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());

        $cardList = new CardList(
            $community->reveal(),
            'Title',
            [CardType::get(CardType::MEMBER)],
            Sorting::get(Sorting::ALPHABETICAL)
        );

        $member = $this->prophesize(Member::class);

        $repository
            ->getSortedByName($community->reveal(), null, $cardList->getLimit())
            ->willReturn([$member->reveal()])
        ;

        $provider = new MemberCardProvider($repository->reveal());

        $cards = $provider->getCards($cardList);

        self::assertEquals([new MemberCard($member->reveal())], $cards);
    }

    /**
     * @dataProvider provideTestSupports
     */
    public function testSupports(CardList $cardList, bool $expectedResult): void
    {
        $repository = $this->prophesize(MemberRepositoryInterface::class);

        $provider = new MemberCardProvider($repository->reveal());

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
                [CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            true,
        ];

        yield 'wrong sorting' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::DATE)
            ),
            false,
        ];

        yield 'too many object' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::COMPANY), CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            false,
        ];

        yield 'everything wrong' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::COMPANY), CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::DATE)
            ),
            false,
        ];
    }
}
