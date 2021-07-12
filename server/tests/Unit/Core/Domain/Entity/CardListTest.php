<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

class CardListTest extends TestCase
{
    use ProphecyTrait;

    public function testMatch(): void
    {
        $tagA = $this->prophesize(Tag::class);
        $tagA->getId()->willReturn(1);
        $tagB = $this->prophesize(Tag::class);
        $tagB->getId()->willReturn(2);
        $tagC = $this->prophesize(Tag::class);
        $tagC->getId()->willReturn(3);
        $tagD = $this->prophesize(Tag::class);
        $tagD->getId()->willReturn(4);

        $goal = $this->prophesize(Goal::class);
        $goal->getTag()->willReturn($tagA->reveal());
        $goalWithUnknowTag = $this->prophesize(Goal::class);
        $goalWithUnknowTag->getTag()->willReturn($tagD);

        $member = $this->prophesize(Member::class);
        $member->getMainGoals()->willReturn(new ArrayCollection([$goal->reveal()]));
        $memberUnknowTag = $this->prophesize(Member::class);
        $memberUnknowTag->getMainGoals()->willReturn(new ArrayCollection([$goalWithUnknowTag->reveal()]));
        $memberEmpty = $this->prophesize(Member::class);
        $memberEmpty->getMainGoals()->willReturn(new ArrayCollection());

        $community = new Community('Rocking Community');

        $cardList = new CardList(
            $community,
            'Hello Title',
            [CardType::get(CardType::MEMBER)],
            Sorting::get(Sorting::ALPHABETICAL),
        );
        new CardList\Tag($cardList, $tagA->reveal());
        new CardList\Tag($cardList, $tagB->reveal());
        new CardList\Tag($cardList, $tagC->reveal());

        $cardListEmptyTags = new CardList(
            $community,
            'Hello Title',
            [CardType::get(CardType::MEMBER)],
            Sorting::get(Sorting::ALPHABETICAL),
        );

        self::assertTrue($cardListEmptyTags->match(null));
        self::assertTrue($cardListEmptyTags->match($member->reveal()));
        self::assertFalse($cardList->match(null));
        self::assertFalse($cardList->match($memberEmpty->reveal()));
        self::assertFalse($cardList->match($memberUnknowTag->reveal()));
        self::assertTrue($cardList->match($member->reveal()));
    }

    public function testGetPositionForMemberWithout(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());
        $tag = $this->prophesize(Tag::class);

        $cardList = new CardList(
            $community->reveal(),
            'title',
            [CardType::get(CardType::MEMBER)],
            Sorting::get(Sorting::ALPHABETICAL),
            1
        );

        new CardList\Tag($cardList, $tag->reveal(), 2);

        self::assertEquals(1, $cardList->getPositionForMember(null));
    }

    public function testGetPositionForMemberWithMemberNoMainGoal(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());
        $tag = $this->prophesize(Tag::class);
        $member = $this->prophesize(Member::class);
        $member->getMainGoals()->willReturn(new ArrayCollection());

        $cardList = new CardList(
            $community->reveal(),
            'title',
            [CardType::get(CardType::MEMBER)],
            Sorting::get(Sorting::ALPHABETICAL),
            1
        );

        new CardList\Tag($cardList, $tag->reveal(), 2);

        self::assertEquals(1, $cardList->getPositionForMember($member->reveal()));
    }

    public function testGetPositionForMemberWithMemberOverridedPosition(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());
        $tag = $this->prophesize(Tag::class);
        $tag->getId()->willReturn(1);
        $member = $this->prophesize(Member::class);
        $goal = $this->prophesize(Goal::class);
        $goal->getTag()->willReturn($tag->reveal());
        $member->getMainGoals()->willReturn(new ArrayCollection([$goal->reveal()]));

        $cardList = new CardList(
            $community->reveal(),
            'title',
            [CardType::get(CardType::MEMBER)],
            Sorting::get(Sorting::ALPHABETICAL),
            1
        );

        new CardList\Tag($cardList, $tag->reveal(), 2);

        self::assertEquals(2, $cardList->getPositionForMember($member->reveal()));
    }

    public function testGetPositionForMemberWithMemberDefaultPosition(): void
    {
        $community = $this->prophesize(Community::class);
        $community->getCardLists()->willReturn(new ArrayCollection());
        $tag1 = $this->prophesize(Tag::class);
        $tag1->getId()->willReturn(1);
        $tag2 = $this->prophesize(Tag::class);
        $tag2->getId()->willReturn(2);
        $member = $this->prophesize(Member::class);
        $goal = $this->prophesize(Goal::class);
        $goal->getTag()->willReturn($tag1->reveal());
        $member->getMainGoals()->willReturn(new ArrayCollection([$goal->reveal()]));

        $cardList = new CardList(
            $community->reveal(),
            'title',
            [CardType::get(CardType::MEMBER)],
            Sorting::get(Sorting::ALPHABETICAL),
            1
        );

        new CardList\Tag($cardList, $tag2->reveal(), 2);

        self::assertEquals(1, $cardList->getPositionForMember($member->reveal()));
    }
}
