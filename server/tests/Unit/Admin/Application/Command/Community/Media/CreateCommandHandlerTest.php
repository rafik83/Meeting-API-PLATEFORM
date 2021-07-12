<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\Media;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\Media\CreateCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Media\CreateCommandHandler;
use Proximum\Vimeet365\Admin\Application\Event\CommunityMedia\MediaVideoUploadedEvent;
use Proximum\Vimeet365\Common\Messenger\EventBusInterface;
use Proximum\Vimeet365\Core\Application\Filesystem\MediaVideosFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityMediaRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function test(): void
    {
        $video = new UploadedFile(__DIR__ . '/../../../../../files/media/video.mp4', 'video.mp4', 'video/mp4', test: true);

        $mediaRepository = $this->prophesize(CommunityMediaRepositoryInterface::class);
        $mediaRepository->add(Argument::type(Media::class), true)->shouldBeCalledOnce();

        $filesystem = $this->prophesize(MediaVideosFilesystemInterface::class);
        $filesystem->upload(Argument::type(Media::class), $video)->willReturn('video.mp4');

        $community = $this->prophesize(Community::class);
        $community->getLanguages()->willReturn(['en']);

        $eventBus = $this->prophesize(EventBusInterface::class);
        $eventBus->dispatch(Argument::type(MediaVideoUploadedEvent::class))->shouldBeCalled();

        $handler = new CreateCommandHandler($mediaRepository->reveal(), $filesystem->reveal(), $eventBus->reveal());

        $command = new CreateCommand($community->reveal());
        $command->mediaType = Media\MediaType::get(Media\MediaType::INTERVIEW);
        $command->tags = [];
        $command->video = $video;
        $command->published = true;
        $command->translations['en']->name = 'Name';
        $command->translations['en']->description = 'Description';
        $command->translations['en']->ctaLabel = 'cta label';
        $command->translations['en']->ctaUrl = 'http://cta/';

        $media = $handler($command);

        self::assertEquals($command->translations['en']->name, $media->getTranslation('en')->getName());
        self::assertEquals($command->translations['en']->description, $media->getTranslation('en')->getDescription());
        self::assertEquals($command->translations['en']->ctaLabel, $media->getTranslation('en')->getCtaLabel());
        self::assertEquals($command->translations['en']->ctaUrl, $media->getTranslation('en')->getCtaUrl());
        self::assertEquals($command->mediaType, $media->getMediaType());
        self::assertEquals('video.mp4', $media->getVideo());
    }
}
