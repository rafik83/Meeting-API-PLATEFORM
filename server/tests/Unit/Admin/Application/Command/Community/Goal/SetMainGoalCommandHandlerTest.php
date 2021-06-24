<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\Goal;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\Goal\SetMainGoalCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Goal\SetMainGoalCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;

class SetMainGoalCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testNew(): void
    {
        $community = new Community('Space');

        $command = new SetMainGoalCommand($community);
        $nomenclature = $this->prophesize(Nomenclature::class);

        $command->nomenclature = $nomenclature->reveal();
        $command->min = 1;
        $command->max = 4;

        $handler = new SetMainGoalCommandHandler();

        $handler($command);
        $mainGoal = $community->getMainGoal();

        self::assertNotNull($mainGoal);
        self::assertEquals(1, $mainGoal->getMin());
        self::assertEquals(4, $mainGoal->getMax());
    }

    public function testUpdate(): void
    {
        $community = new Community('Space');

        $nomenclature = $this->prophesize(Nomenclature::class);
        new Community\Goal($community, $nomenclature->reveal(), null, null, null, 0, 4);

        $command = new SetMainGoalCommand($community);
        $command->nomenclature = $nomenclature->reveal();
        $command->min = 1;
        $command->max = 2;

        $handler = new SetMainGoalCommandHandler();

        $handler($command);
        $mainGoal = $community->getMainGoal();

        self::assertNotNull($mainGoal);
        self::assertEquals(1, $mainGoal->getMin());
        self::assertEquals(2, $mainGoal->getMax());
    }

    public function testSetInfiniteValueForMax(): void
    {
        $community = new Community('Space');

        $command = new SetMainGoalCommand($community);
        $nomenclature = $this->prophesize(Nomenclature::class);

        $command->nomenclature = $nomenclature->reveal();
        $command->min = 1;
        $command->max = 0;

        $handler = new SetMainGoalCommandHandler();

        $handler($command);
        $mainGoal = $community->getMainGoal();

        self::assertNotNull($mainGoal);
        self::assertEquals(1, $mainGoal->getMin());
        self::assertNull($mainGoal->getMax());
    }
}
