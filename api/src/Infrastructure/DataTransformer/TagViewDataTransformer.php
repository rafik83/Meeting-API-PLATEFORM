<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Application\View\TagView;
use Proximum\Vimeet365\Domain\Entity\Tag;

class TagViewDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof Tag) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', Tag::class, \get_class($object))
            );
        }

        return TagView::create($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return TagView::class === $to && $data instanceof Tag;
    }
}
