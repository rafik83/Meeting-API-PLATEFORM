<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\Event;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\Event\DeleteCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Event\DeleteCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityEventRepositoryInterface;

class DeleteCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function test(): void
    {
        $event = $this->prophesize(Event::class);
        $command = new DeleteCommand($event->reveal());
        $repository = $this->prophesize(CommunityEventRepositoryInterface::class);
        $handler = new DeleteCommandHandler($repository->reveal());

        $repository->remove($event->reveal())->shouldBeCalledOnce();

        $handler($command);
    }
}
