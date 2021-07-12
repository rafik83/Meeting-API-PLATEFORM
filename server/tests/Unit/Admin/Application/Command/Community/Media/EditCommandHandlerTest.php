<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\Admin\Application\Command\Community\Media;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\Media\EditCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Media\EditCommandHandler;
use Proximum\Vimeet365\Admin\Application\Event\CommunityMedia\MediaVideoUploadedEvent;
use Proximum\Vimeet365\Common\Messenger\EventBusInterface;
use Proximum\Vimeet365\Core\Application\Filesystem\MediaVideosFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EditCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testWithoutPictureChange(): void
    {
        $filesystem = $this->prophesize(MediaVideosFilesystemInterface::class);
        $filesystem->upload(Argument::any())->shouldNotBeCalled();

        $eventBus = $this->prophesize(EventBusInterface::class);

        $handler = new EditCommandHandler($filesystem->reveal(), $eventBus->reveal());

        $community = $this->prophesize(Community::class);
        $community->getLanguages()->willReturn(['en']);

        $media = new Media($community->reveal(), Media\MediaType::get(Media\MediaType::INTERVIEW), []);
        $media->setTranslation('en', 'Media name', 'Media Description', null, null);

        self::assertFalse($media->isPublished());

        $command = new EditCommand($media);
        $command->translations['en']->name = 'New media name';
        $command->translations['en']->description = 'New media description';
        $command->translations['en']->ctaUrl = 'http://new-cta';
        $command->translations['en']->ctaLabel = 'new cta';
        $command->published = true;

        $handler($command);

        self::assertEquals($command->translations['en']->name, $media->getTranslation('en')->getName());
        self::assertEquals($command->translations['en']->description, $media->getTranslation('en')->getDescription());
        self::assertEquals($command->translations['en']->ctaLabel, $media->getTranslation('en')->getCtaLabel());
        self::assertEquals($command->translations['en']->ctaUrl, $media->getTranslation('en')->getCtaUrl());
        self::assertEquals($command->mediaType, $media->getMediaType());
        self::assertTrue($media->isPublished());
    }

    public function testWithPictureChange(): void
    {
        $filesystem = $this->prophesize(MediaVideosFilesystemInterface::class);
        $filesystem->remove('old-video.mp4')->shouldBeCalled();
        $video = new UploadedFile(__DIR__ . '/../../../../../files/media/video.mp4', 'video.mp4', 'video/mp4', test: true);
        $filesystem->upload(Argument::type(Media::class), $video)->willReturn('video.mp4');

        $eventBus = $this->prophesize(EventBusInterface::class);
        $eventBus->dispatch(Argument::type(MediaVideoUploadedEvent::class))->shouldBeCalled();

        $handler = new EditCommandHandler($filesystem->reveal(), $eventBus->reveal());

        $community = $this->prophesize(Community::class);
        $community->getLanguages()->willReturn(['en']);

        $media = new Media($community->reveal(), Media\MediaType::get(Media\MediaType::INTERVIEW), []);
        $media->setTranslation('en', 'Media name', 'Media Description', null, null);
        $media->setVideo('old-video.mp4');

        self::assertFalse($media->isPublished());

        $command = new EditCommand($media);
        $command->translations['en']->name = 'New media name';
        $command->translations['en']->description = 'New media description';
        $command->translations['en']->ctaUrl = 'http://new-cta';
        $command->translations['en']->ctaLabel = 'new cta';
        $command->video = $video;
        $command->published = true;

        $handler($command);

        self::assertEquals($command->translations['en']->name, $media->getTranslation('en')->getName());
        self::assertEquals($command->translations['en']->description, $media->getTranslation('en')->getDescription());
        self::assertEquals($command->translations['en']->ctaLabel, $media->getTranslation('en')->getCtaLabel());
        self::assertEquals($command->translations['en']->ctaUrl, $media->getTranslation('en')->getCtaUrl());
        self::assertEquals($command->mediaType, $media->getMediaType());
        self::assertTrue($media->isPublished());
    }
}
