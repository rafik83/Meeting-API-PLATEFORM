<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\Paths;
use ApiPlatform\Core\OpenApi\OpenApi;

class RemoveEndpointDecorator implements OpenApiFactoryInterface
{
    private const ENDPOINT_TO_REMOVE = [
        '/api/communityCardList',
        '/api/communityCardList/{id}',
        '/api/communityCardList/{id}',
        '/api/member_cards/{id}',
        '/api/company_cards/{id}',
        '/api/media_cards/{id}',
        '/api/event_cards/{id}',
        '/api/card',
        '/api/card/{id}',
        '/api/communityGoals',
        '/api/communityGoals/{id}',
    ];

    public function __construct(
        private OpenApiFactoryInterface $decorated
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        /** @var array<string, PathItem> $paths */
        $paths = $openApi->getPaths()->getPaths();

        $filteredPaths = new Paths();
        foreach ($paths as $path => $pathItem) {
            if (\in_array($path, self::ENDPOINT_TO_REMOVE, true)) {
                continue;
            }

            $filteredPaths->addPath($path, $pathItem);
        }

        return $openApi->withPaths($filteredPaths);
    }
}
