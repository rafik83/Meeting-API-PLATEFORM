<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataProvider\HubSpot;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Proximum\Vimeet365\Api\Application\Query\HubSpot\SearchCompaniesQuery;
use Proximum\Vimeet365\Api\Application\View\HubSpot\CompanyView;
use Proximum\Vimeet365\Common\Messenger\QueryBusInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CompanyDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private RequestStack $requestStack;
    private QueryBusInterface $queryBus;

    public function __construct(RequestStack $requestStack, QueryBusInterface $queryBus)
    {
        $this->requestStack = $requestStack;
        $this->queryBus = $queryBus;
    }

    /**
     * @return CompanyView[]
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request === null) {
            return [];
        }

        $domain = $request->query->get('domain', '');
        $limit = $request->query->getInt('limit', 10);

        if (\strlen($domain) < 3) {
            return [];
        }

        return $this->queryBus->handle(new SearchCompaniesQuery($domain, $limit));
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return CompanyView::class === $resourceClass;
    }
}
