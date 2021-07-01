<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\Goal;

use PHPUnit\Framework\TestCase;
use Proximum\Vimeet365\Admin\Application\Command\Community\Goal\RefineMainGoalCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Goal\RefineMainGoalCommandHandler;
use Proximum\Vimeet365\Admin\Application\Dto\Community\Goal\RefinedGoalDto;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

class RefineMainGoalCommandHandlerTest extends TestCase
{
    public function testEmpty(): void
    {
        $community = new Community('Space', ['en'], 'en');
        $nomenclature = new Nomenclature('nomenclature', $community);
        $mainGoal = new Goal($community, $nomenclature);

        $command = new RefineMainGoalCommand($mainGoal);
        $handler = new RefineMainGoalCommandHandler();

        self::assertEmpty($mainGoal->getChildren());

        $handler($command);

        self::assertEmpty($mainGoal->getChildren());
    }

    public function testAdd(): void
    {
        $community = new Community('Space', ['en'], 'en');
        $nomenclature = new Nomenclature('nomenclature', $community);
        $tagA = new Tag('tagA');
        $tagB = new Tag('tagB');
        $nomenclature->addTag($tagA);
        $nomenclature->addTag($tagB);
        $subNomenclature = new Nomenclature('sub-nomenclature', $community);

        $mainGoal = new Goal($community, $nomenclature);

        $command = new RefineMainGoalCommand($mainGoal);
        $dto = new RefinedGoalDto($mainGoal);
        $dto->nomenclature = $subNomenclature;
        $dto->tag = $tagA;

        $command->refinedGoals[] = $dto;
        $handler = new RefineMainGoalCommandHandler();

        self::assertCount(0, $mainGoal->getChildren());

        $handler($command);

        self::assertCount(1, $mainGoal->getChildren());
    }

    public function testRemove(): void
    {
        $community = new Community('Space', ['en'], 'en');
        $nomenclature = new Nomenclature('nomenclature', $community);
        $tagA = new Tag('tagA');
        $tagB = new Tag('tagB');
        $nomenclature->addTag($tagA);
        $nomenclature->addTag($tagB);
        $subNomenclature = new Nomenclature('sub-nomenclature', $community);

        $mainGoal = new Goal($community, $nomenclature);
        $childGoal = new Goal($community, $subNomenclature, $tagA, $mainGoal);

        $command = new RefineMainGoalCommand($mainGoal);
        $command->refinedGoals = [];

        $handler = new RefineMainGoalCommandHandler();

        self::assertCount(1, $mainGoal->getChildren());

        $handler($command);

        self::assertCount(0, $mainGoal->getChildren());
    }

    public function testUpdate(): void
    {
        $community = new Community('Space', ['en'], 'en');
        $nomenclature = new Nomenclature('nomenclature', $community);
        $tagA = new Tag('tagA');
        $tagB = new Tag('tagB');
        $nomenclature->addTag($tagA);
        $nomenclature->addTag($tagB);
        $subNomenclature = new Nomenclature('sub-nomenclature', $community);

        $mainGoal = new Goal($community, $nomenclature);
        $childGoal = new Goal($community, $subNomenclature, $tagA, $mainGoal, 0, 1, 0);

        $command = new RefineMainGoalCommand($mainGoal);
        $command->refinedGoals[0]->min = 0;
        $command->refinedGoals[0]->max = 1;

        $handler = new RefineMainGoalCommandHandler();

        self::assertCount(1, $mainGoal->getChildren());
        self::assertEquals(1, $mainGoal->getChildren()->first()->getMin());
        self::assertEquals(0, $mainGoal->getChildren()->first()->getMax());

        $handler($command);

        self::assertCount(1, $mainGoal->getChildren());
        self::assertEquals(0, $mainGoal->getChildren()->first()->getMin());
        self::assertEquals(1, $mainGoal->getChildren()->first()->getMax());
    }
}
