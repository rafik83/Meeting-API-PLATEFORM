<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataTransformer\Card;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Api\Application\View\Card\CardView;
use Proximum\Vimeet365\Api\Application\View\Card\EventCardView;
use Proximum\Vimeet365\Api\Application\View\TagView;
use Proximum\Vimeet365\Core\Application\Card\EventCard;
use Proximum\Vimeet365\Core\Application\Filesystem\Assets;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\Asset\Packages;

class EventCardViewDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private Packages $assetPackages
    ) {
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CardView::class === $to && $data instanceof EventCard;
    }

    /**
     * @param object|EventCard $object
     */
    public function transform($object, string $to, array $context = []): CardView
    {
        \assert($object instanceof EventCard);

        $event = $object->getEvent();

        $picture = null;
        if ($event->getPicture() !== null) {
            $picture = $this->assetPackages->getUrl($event->getPicture(), Assets::EVENT_PICTURES);
        }

        return new EventCardView(
            $object->getId(),
            $picture,
            $object->getName(),
            $event->getStartDate(),
            $event->getEndDate(),
            $event->getEventType(),
            $event->getRegisterUrl(),
            $event->getFindOutMoreUrl(),
            $this->extractTags($event)
        );
    }

    /**
     * @return TagView[]
     */
    private function extractTags(Event $event): array
    {
        $eventNomenclature = $event->getCommunity()->getEventNomenclature();

        if ($eventNomenclature === null) {
            return [];
        }

        return $event->getTags()
            ->map(function (Tag $tag) use ($eventNomenclature): TagView {
                $nomenclatureTag = $eventNomenclature->findTag($tag);

                if ($nomenclatureTag === null) {
                    throw new \RuntimeException(
                        sprintf(
                            'The Tag %s was remove from the nomenclature %s',
                            (string) $tag,
                            $eventNomenclature->getReference()
                        )
                    );
                }

                return TagView::createFromNomenclatureTag($nomenclatureTag);
            })
            ->getValues()
        ;
    }
}
