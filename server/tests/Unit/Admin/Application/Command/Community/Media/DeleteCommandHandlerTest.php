<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\Media;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\Media\DeleteCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Media\DeleteCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityMediaRepositoryInterface;

class DeleteCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function test(): void
    {
        $event = $this->prophesize(Media::class);
        $command = new DeleteCommand($event->reveal());
        $repository = $this->prophesize(CommunityMediaRepositoryInterface::class);
        $handler = new DeleteCommandHandler($repository->reveal());

        $repository->remove($event->reveal())->shouldBeCalledOnce();

        $handler($command);
    }
}
