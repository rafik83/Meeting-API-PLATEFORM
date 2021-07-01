<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

class MemberTest extends TestCase
{
    use ProphecyTrait;

    public function testGetMainGoals(): void
    {
        $community = $this->prophesize(Community::class);
        $account = $this->prophesize(Account::class);
        $account->getMembers()->willReturn(new ArrayCollection());

        $member = new Member(
            $community->reveal(),
            $account->reveal(),
        );

        $tagA = $this->prophesize(Tag::class);
        $tagB = $this->prophesize(Tag::class);
        $tagC = $this->prophesize(Tag::class);

        $mainCommunityGoal = $this->prophesize(Community\Goal::class);
        $communityGoal = $this->prophesize(Community\Goal::class);

        $communityGoal->getParent()->willReturn($mainCommunityGoal->reveal());
        $communityGoal->getTag()->willReturn($tagA->reveal());

        // add goals
        $mainGoal = new Member\Goal($member, $mainCommunityGoal->reveal(), $tagA->reveal(), 0);
        $secondaryGoal = new Member\Goal($member, $mainCommunityGoal->reveal(), $tagB->reveal(), 1);
        $childMainGoal = new Member\Goal($member, $communityGoal->reveal(), $tagC->reveal(), null);

        self::assertCount(2, $member->getMainGoals());
        self::assertEquals($mainGoal, $member->getMainGoals()->get(0));
        self::assertEquals($secondaryGoal, $member->getMainGoals()->get(1));
    }

    public function testGetRefinedGoals(): void
    {
        $community = $this->prophesize(Community::class);
        $account = $this->prophesize(Account::class);
        $account->getMembers()->willReturn(new ArrayCollection());

        $member = new Community\Member(
            $community->reveal(),
            $account->reveal(),
        );

        $tagA = $this->prophesize(Tag::class);
        $tagB = $this->prophesize(Tag::class);
        $tagC = $this->prophesize(Tag::class);
        $tagD = $this->prophesize(Tag::class);
        $tagE = $this->prophesize(Tag::class);

        $mainCommunityGoal = $this->prophesize(Community\Goal::class);
        $mainCommunityGoal->getParent()->willReturn(null);
        $mainCommunityGoal->getId()->willReturn(1);
        $communityGoal = $this->prophesize(Community\Goal::class);
        $mainCommunityGoal->getId()->willReturn(2);

        $communityGoal->getParent()->willReturn($mainCommunityGoal->reveal());
        $communityGoal->getTag()->willReturn($tagA->reveal());

        // add goals
        $mainGoal = new Member\Goal($member, $mainCommunityGoal->reveal(), $tagA->reveal(), 0);
        new Member\Goal($member, $mainCommunityGoal->reveal(), $tagB->reveal(), 1);
        new Member\Goal($member, $communityGoal->reveal(), $tagC->reveal(), null);
        $firstChildGoal = new Member\Goal($member, $communityGoal->reveal(), $tagD->reveal(), 0);
        $secondChildGoal = new Member\Goal($member, $communityGoal->reveal(), $tagE->reveal(), 1);

        self::assertCount(2, $member->getRefinedGoals($mainGoal));
        self::assertEquals($firstChildGoal, $member->getRefinedGoals($mainGoal)->get(0));
        self::assertEquals($secondChildGoal, $member->getRefinedGoals($mainGoal)->get(1));
    }
}
