<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Bridge\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\Response;
use ApiPlatform\Core\OpenApi\OpenApi;

class NomenclatureDecorator implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        /** @var PathItem $pathItem */
        $pathItem = $openApi->getPaths()->getPath('/api/nomenclatures/{id}');
        /** @var Operation $operation */
        $operation = $pathItem->getGet();
        /** @var Response[] $responses */
        $responses = $operation->getResponses();

        /** @var PathItem $endpoint */
        $endpoint = $openApi->getPaths()->getPath('/api/nomenclatures/job_position');
        /** @var Operation $operation */
        $operation = $endpoint->getGet();
        $operation = $operation
            ->withParameters([])
            ->withResponses($responses)
        ;

        $endpoint = $endpoint->withGet($operation);

        $openApi->getPaths()->addPath('/api/nomenclatures/job_position', $endpoint);

        return $openApi;
    }
}
