<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Proximum\Vimeet365\Api\Application\Query\Community\CommunitiesViewQuery;
use Proximum\Vimeet365\Api\Application\View\CommunityListView;
use Proximum\Vimeet365\Common\Messenger\QueryBusInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;

final class CommunityCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Community::class === $resourceClass;
    }

    /**
     * @return CommunityListView[]
     */
    public function getCollection(string $resourceClass, ?string $operationName = null): array
    {
        return $this->queryBus->handle(new CommunitiesViewQuery());
    }
}
