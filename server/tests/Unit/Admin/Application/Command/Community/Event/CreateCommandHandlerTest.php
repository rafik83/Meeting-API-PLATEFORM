<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\Event;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\Event\CreateCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Event\CreateCommandHandler;
use Proximum\Vimeet365\Core\Application\Filesystem\EventPictureFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityEventRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function test(): void
    {
        $picture = new UploadedFile(__DIR__ . '/../../../../../files/event/picture.png', 'picture.png', 'image/png', test: true);

        $eventRepository = $this->prophesize(CommunityEventRepositoryInterface::class);
        $eventRepository->add(Argument::type(Event::class), true)->shouldBeCalledOnce();

        $filesystem = $this->prophesize(EventPictureFilesystemInterface::class);
        $filesystem->upload(Argument::type(Event::class), $picture)->willReturn('picture.png');

        $community = $this->prophesize(Community::class);
        $community->getEvents()->willReturn(new ArrayCollection());

        $handler = new CreateCommandHandler($eventRepository->reveal(), $filesystem->reveal());

        $command = new CreateCommand($community->reveal());
        $command->name = 'Event name';
        $command->eventType = Community\EventType::get(Community\EventType::FACE_TO_FACE);
        $command->startDate = new \DateTimeImmutable('2021-01-01');
        $command->endDate = new \DateTimeImmutable('2021-01-01');
        $command->picture = $picture;
        $command->published = true;
        $command->registerUrl = 'http://url.com/';
        $command->findOutMoreUrl = 'http://url.com/';

        $event = $handler($command);

        self::assertEquals($command->name, $event->getName());
        self::assertEquals($command->eventType, $event->getEventType());
        self::assertEquals($command->startDate, $event->getStartDate());
        self::assertEquals($command->endDate, $event->getEndDate());
        self::assertEquals('picture.png', $event->getPicture());
    }
}
