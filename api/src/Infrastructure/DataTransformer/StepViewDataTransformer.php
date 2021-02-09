<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Application\View\CommunityStepView;
use Proximum\Vimeet365\Domain\Entity\Community\Step;

class StepViewDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof Step) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', Step::class, \get_class($object))
            );
        }

        return CommunityStepView::create($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CommunityStepView::class === $to && $data instanceof Step;
    }
}
