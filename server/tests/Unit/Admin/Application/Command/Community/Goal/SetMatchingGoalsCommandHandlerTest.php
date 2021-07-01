<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\Goal;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\Goal\SetMatchingGoalsCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Goal\SetMatchingGoalsCommandHandler;
use Proximum\Vimeet365\Admin\Application\Dto\Community\Goal\MatchingGoalDto;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

class SetMatchingGoalsCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testEmpty(): void
    {
        $matching = new ArrayCollection();

        $tagA = $this->prophesize(Tag::class);
        $tagA->getId()->willReturn(1);
        $tagB = $this->prophesize(Tag::class);
        $tagB->getId()->willReturn(2);
        $tagC = $this->prophesize(Tag::class);
        $tagC->getId()->willReturn(3);

        $goal = $this->prophesize(Goal::class);

        $goal->getMatching()->willReturn($matching);

        $command = new SetMatchingGoalsCommand($goal->reveal());
        $command->matchingTags = [
            new MatchingGoalDto($goal->reveal(), $tagA->reveal(), $tagB->reveal()),
            new MatchingGoalDto($goal->reveal(), $tagA->reveal(), $tagC->reveal()),
            new MatchingGoalDto($goal->reveal(), $tagB->reveal(), $tagC->reveal()),
        ];

        $handler = new SetMatchingGoalsCommandHandler();
        $handler($command);

        self::assertCount(3, $matching);

        $firstMatch = $matching->get(0);
        self::assertEquals(1, $firstMatch->getFrom()->getId());
        self::assertEquals(2, $firstMatch->getTo()->getId());
        self::assertEquals(0, $firstMatch->getPriority());

        $firstMatch = $matching->get(1);
        self::assertEquals(1, $firstMatch->getFrom()->getId());
        self::assertEquals(3, $firstMatch->getTo()->getId());
        self::assertEquals(1, $firstMatch->getPriority());

        $firstMatch = $matching->get(2);
        self::assertEquals(2, $firstMatch->getFrom()->getId());
        self::assertEquals(3, $firstMatch->getTo()->getId());
        self::assertEquals(0, $firstMatch->getPriority());
    }

    public function testRemove(): void
    {
        $tagA = $this->prophesize(Tag::class);
        $tagA->getId()->willReturn(1);
        $tagB = $this->prophesize(Tag::class);
        $tagB->getId()->willReturn(2);

        $community = $this->prophesize(Community::class);
        $community->getGoals()->willReturn(new ArrayCollection());

        $goal = new Goal(
            $community->reveal(),
            $this->prophesize(Nomenclature::class)->reveal()
        );

        new Goal\GoalMatching($goal, $tagA->reveal(), $tagB->reveal(), 1);

        $command = new SetMatchingGoalsCommand($goal);
        $command->matchingTags = [];

        $handler = new SetMatchingGoalsCommandHandler();
        $handler($command);

        self::assertCount(0, $goal->getMatching());
    }

    public function testChangePriority(): void
    {
        $tagA = $this->prophesize(Tag::class);
        $tagA->getId()->willReturn(1);
        $tagB = $this->prophesize(Tag::class);
        $tagB->getId()->willReturn(2);
        $tagC = $this->prophesize(Tag::class);
        $tagC->getId()->willReturn(3);

        $community = $this->prophesize(Community::class);
        $community->getGoals()->willReturn(new ArrayCollection());

        $goal = new Goal(
            $community->reveal(),
            $this->prophesize(Nomenclature::class)->reveal()
        );

        new Goal\GoalMatching($goal, $tagA->reveal(), $tagB->reveal(), 0);
        new Goal\GoalMatching($goal, $tagA->reveal(), $tagC->reveal(), 1);

        $command = new SetMatchingGoalsCommand($goal);
        $command->matchingTags = [
            new MatchingGoalDto($goal, $tagA->reveal(), $tagC->reveal()),
            new MatchingGoalDto($goal, $tagA->reveal(), $tagB->reveal()),
        ];

        self::assertEquals(0, $goal->getMatching()->get(0)->getPriority());
        self::assertEquals(2, $goal->getMatching()->get(0)->getTo()->getId());
        self::assertEquals(1, $goal->getMatching()->get(1)->getPriority());
        self::assertEquals(3, $goal->getMatching()->get(1)->getTo()->getId());

        $handler = new SetMatchingGoalsCommandHandler();
        $handler($command);

        self::assertCount(2, $goal->getMatching());
        self::assertEquals(1, $goal->getMatching()->get(0)->getPriority());
        self::assertEquals(0, $goal->getMatching()->get(1)->getPriority());
    }
}
