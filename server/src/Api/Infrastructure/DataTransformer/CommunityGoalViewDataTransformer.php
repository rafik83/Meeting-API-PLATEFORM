<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Api\Application\View\Goal\CommunityGoalView;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;

class CommunityGoalViewDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     *
     * @param object|Goal $object
     */
    public function transform($object, string $to, array $context = []): CommunityGoalView
    {
        if (!$object instanceof Goal) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', Goal::class, \get_class($object))
            );
        }

        return new CommunityGoalView($object);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CommunityGoalView::class === $to && $data instanceof Goal;
    }
}
