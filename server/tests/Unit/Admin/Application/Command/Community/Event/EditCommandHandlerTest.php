<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\Event;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\Event\EditCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Event\EditCommandHandler;
use Proximum\Vimeet365\Core\Application\Filesystem\EventPictureFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EditCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testWithoutPictureChange(): void
    {
        $filesystem = $this->prophesize(EventPictureFilesystemInterface::class);
        $filesystem->upload(Argument::any())->shouldNotBeCalled();

        $handler = new EditCommandHandler($filesystem->reveal());

        $event = $this->prophesize(Event::class);
        $event->getName()->willReturn('Event name');
        $event->getEventType()->willReturn(Community\EventType::get(Community\EventType::FACE_TO_FACE));
        $event->getStartDate()->willReturn(new \DateTimeImmutable('2021-01-01'));
        $event->getEndDate()->willReturn(new \DateTimeImmutable('2021-01-01'));
        $event->getRegisterUrl()->willReturn('http:///');
        $event->getFindOutMoreUrl()->willReturn('http:///');
        $event->getTags()->willReturn(new ArrayCollection());
        $event->getCharacterizationTags()->willReturn(new ArrayCollection());
        $event->isPublished()->willReturn(false);

        $command = new EditCommand($event->reveal());
        $command->published = true;

        $event->update(
            'Event name',
            Community\EventType::get(Community\EventType::FACE_TO_FACE),
            new \DateTimeImmutable('2021-01-01'),
            new \DateTimeImmutable('2021-01-01'),
            'http:///',
            'http:///',
            [],
            [],
        )->shouldBeCalledOnce();

        $event->setPublished(true)->shouldBeCalled();

        $handler($command);
    }

    public function testWithPictureChange(): void
    {
        $picture = new UploadedFile(__DIR__ . '/../../../../../files/event/picture.png', 'picture.png', 'image/png', test: true);

        $filesystem = $this->prophesize(EventPictureFilesystemInterface::class);

        $handler = new EditCommandHandler($filesystem->reveal());

        $event = $this->prophesize(Event::class);
        $event->getName()->willReturn('Event name');
        $event->getEventType()->willReturn(Community\EventType::get(Community\EventType::FACE_TO_FACE));
        $event->getStartDate()->willReturn(new \DateTimeImmutable('2021-01-01'));
        $event->getEndDate()->willReturn(new \DateTimeImmutable('2021-01-01'));
        $event->getRegisterUrl()->willReturn('http:///');
        $event->getFindOutMoreUrl()->willReturn('http:///');
        $event->getTags()->willReturn(new ArrayCollection());
        $event->getCharacterizationTags()->willReturn(new ArrayCollection());
        $event->isPublished()->willReturn(false);
        $event->getPicture()->willReturn('previous.png');

        $command = new EditCommand($event->reveal());
        $command->published = true;
        $command->picture = $picture;

        $event->update(
            'Event name',
            Community\EventType::get(Community\EventType::FACE_TO_FACE),
            new \DateTimeImmutable('2021-01-01'),
            new \DateTimeImmutable('2021-01-01'),
            'http:///',
            'http:///',
            [],
            [],
        )->shouldBeCalledOnce();

        $filesystem->remove('previous.png')->shouldBeCalled();
        $filesystem->upload(Argument::type(Event::class), $picture)->willReturn('picture.png');

        $event->setPicture('picture.png')->shouldBeCalled();
        $event->setPublished(true)->shouldBeCalled();

        $handler($command);
    }
}
