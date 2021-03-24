<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Application\View\MemberView;
use Proximum\Vimeet365\Domain\Entity\Member;

class MemberOutputDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     *
     * @param object|Member $data
     */
    public function transform($data, string $to, array $context = []): MemberView
    {
        if (!$data instanceof Member) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', Member::class, \get_class($data))
            );
        }

        return new MemberView(
            (int) $data->getId(),
            $data->getJoinedAt()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return MemberView::class === $to && $data instanceof Member;
    }
}
