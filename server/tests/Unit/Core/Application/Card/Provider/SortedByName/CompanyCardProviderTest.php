<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Application\Card\Provider\SortedByName;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Application\Card\CompanyCard;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName\CompanyCardProvider;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;

class CompanyCardProviderTest extends TestCase
{
    use ProphecyTrait;

    public function testGetCards(): void
    {
        $repository = $this->prophesize(CompanyRepositoryInterface::class);

        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());

        $cardList = new CardList(
            $community->reveal(),
            'Title',
            [CardType::get(CardType::COMPANY)],
            Sorting::get(Sorting::ALPHABETICAL)
        );

        $member = $this->prophesize(Company::class);

        $repository
            ->getSortedByName($community->reveal(), $cardList->getLimit())
            ->willReturn([$member->reveal()])
        ;

        $provider = new CompanyCardProvider($repository->reveal());

        $cards = $provider->getCards($cardList);

        self::assertEquals([new CompanyCard($member->reveal())], $cards);
    }

    /**
     * @dataProvider provideTestSupports
     */
    public function testSupports(CardList $cardList, bool $expectedResult): void
    {
        $repository = $this->prophesize(CompanyRepositoryInterface::class);

        $provider = new CompanyCardProvider($repository->reveal());

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
                [CardType::get(CardType::COMPANY)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            true,
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
