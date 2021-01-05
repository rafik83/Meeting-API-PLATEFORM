<?php

namespace Proximum\Vimeet365\Infrastructure\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Proximum\Vimeet365\Application\Query\Community\CommunityViewQuery;
use Proximum\Vimeet365\Domain\View\CommunityView;
use Proximum\Vimeet365\Infrastructure\Adapter\QueryBusAdapter;

final class CommunityItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(QueryBusAdapter $queryBus) {
        $this->queryBus = $queryBus;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return CommunityView::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?CommunityView
    {
        return $this->queryBus->handle(new CommunityViewQuery($id));
    }
}
