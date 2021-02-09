<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Application\ContextAwareMessageInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ContextAwareInputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof ContextAwareMessageInterface) {
            return $object;
        }

        $object->setContext($context[AbstractNormalizer::OBJECT_TO_POPULATE]);

        return $object;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if (\is_object($data)) {
            return false;
        }

        return null !== ($context['input']['class'] ?? null) && is_subclass_of($context['input']['class'], ContextAwareMessageInterface::class);
    }
}
