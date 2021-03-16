<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Bridge\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
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

        $responses = $openApi->getPaths()->getPath('/api/nomenclatures/{id}')->getGet()->getResponses();

        $endpoint = $openApi->getPaths()->getPath('/api/nomenclatures/job_position');
        $operation = $endpoint->getGet()
            ->withParameters([])
            ->withResponses($responses)
        ;

        $endpoint = $endpoint->withGet($operation);

        $openApi->getPaths()->addPath('/api/nomenclatures/job_position', $endpoint);

        return $openApi;
    }
}
