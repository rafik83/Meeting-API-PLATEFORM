<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Proximum\Vimeet365\Application\Adapter\QueryBusInterface;
use Proximum\Vimeet365\Application\Query\Community\CommunityViewQuery;
use Proximum\Vimeet365\Domain\View\CommunityView;

final class CommunityItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return CommunityView::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?CommunityView
    {
        if (!\is_int($id)) {
            throw new \RuntimeException(sprintf('id must be an integer "%s"', get_debug_type($id)));
        }

        return $this->queryBus->handle(new CommunityViewQuery($id));
    }
}
