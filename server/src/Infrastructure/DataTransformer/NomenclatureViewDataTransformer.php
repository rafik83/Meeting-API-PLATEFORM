<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Application\View\NomenclatureView;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;

class NomenclatureViewDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof Nomenclature) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', Nomenclature::class, \get_class($object))
            );
        }

        return NomenclatureView::create($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return NomenclatureView::class === $to && $data instanceof Nomenclature;
    }
}
