<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Api\Application\View\CommunityCardListView;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

class CardListViewDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     *
     * @param object|CardList $object
     */
    public function transform($object, string $to, array $context = []): CommunityCardListView
    {
        if (!$object instanceof CardList) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', CardList::class, \get_class($object))
            );
        }

        return new CommunityCardListView(
            (int) $object->getId(),
            $object->getPosition(),
            $object->getTitle()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CommunityCardListView::class === $to && $data instanceof CardList;
    }
}
