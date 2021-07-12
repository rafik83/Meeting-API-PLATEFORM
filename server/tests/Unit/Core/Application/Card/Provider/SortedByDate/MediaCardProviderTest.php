<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Application\Card\Provider\SortedByDate;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Application\Card\MediaCard;
use Proximum\Vimeet365\Core\Application\Card\Provider\SortedByDate\MediaCardProvider;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityMediaRepositoryInterface;

class MediaCardProviderTest extends TestCase
{
    use ProphecyTrait;

    public function testGetCards(): void
    {
        $repository = $this->prophesize(CommunityMediaRepositoryInterface::class);

        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());

        $cardList = new CardList(
            $community->reveal(),
            'Title',
            [CardType::get(CardType::MEDIA)],
            Sorting::get(Sorting::ALPHABETICAL)
        );

        $event = $this->prophesize(Media::class);

        $repository
            ->getSortedByDate($community->reveal(), $cardList->getLimit())
            ->willReturn([$event->reveal()])
        ;

        $provider = new MediaCardProvider($repository->reveal());

        $cards = $provider->getCards($cardList);

        self::assertEquals([new MediaCard($event->reveal())], $cards);
    }

    /**
     * @dataProvider provideTestSupports
     */
    public function testSupports(CardList $cardList, bool $expectedResult): void
    {
        $repository = $this->prophesize(CommunityMediaRepositoryInterface::class);

        $provider = new MediaCardProvider($repository->reveal());

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
                [CardType::get(CardType::MEDIA)],
                Sorting::get(Sorting::DATE)
            ),
            true,
        ];

        yield 'wrong sorting' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::MEDIA)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            false,
        ];

        yield 'too many object' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::MEDIA), CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::DATE)
            ),
            false,
        ];

        yield 'everything wrong' => [
            new CardList(
                $community->reveal(),
                'Title',
                [CardType::get(CardType::MEDIA), CardType::get(CardType::MEMBER)],
                Sorting::get(Sorting::ALPHABETICAL)
            ),
            false,
        ];
    }
}
