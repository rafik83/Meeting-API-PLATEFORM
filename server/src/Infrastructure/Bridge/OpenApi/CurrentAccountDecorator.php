<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Bridge\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\OpenApi;

class CurrentAccountDecorator implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        /** @var PathItem $endpoint */
        $endpoint = $openApi->getPaths()->getPath('/api/accounts/me');

        /** @var Operation $operation */
        $operation = $endpoint->getGet();
        $operation = $operation
            ->withParameters([])
        ;

        $endpoint = $endpoint->withGet($operation);

        $openApi->getPaths()->addPath('/api/accounts/me', $endpoint);

        return $openApi;
    }
}
