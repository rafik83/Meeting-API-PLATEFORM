<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataTransformer\Card;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Api\Application\View\Card\CardView;
use Proximum\Vimeet365\Api\Application\View\Card\MediaCardView;
use Proximum\Vimeet365\Core\Application\Card\MediaCard;
use Proximum\Vimeet365\Core\Application\Filesystem\Assets;
use Symfony\Component\Asset\Packages;

class MediaCardViewDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private Packages $assetPackages
    ) {
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CardView::class === $to && $data instanceof MediaCard;
    }

    /**
     * @param object|MediaCard $object
     */
    public function transform($object, string $to, array $context = []): CardView | MediaCardView
    {
        \assert($object instanceof MediaCard);

        $event = $object->getMedia();

        $video = null;
        if ($event->getVideo() !== null) {
            $video = $this->assetPackages->getUrl($event->getVideo(), Assets::MEDIA_VIDEOS);
        }

        $translation = $event->getTranslation();

        return new MediaCardView(
            $object->getId(),
            $video,
            (string) $translation?->getName(),
            (string) $translation?->getDescription(),
            $event->getMediaType(),
            $translation?->getCtaLabel(),
            $translation?->getCtaUrl(),
        );
    }
}
