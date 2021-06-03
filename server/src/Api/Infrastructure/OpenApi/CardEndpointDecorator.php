<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\MediaType;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\OpenApi;

class CardEndpointDecorator implements OpenApiFactoryInterface
{
    public function __construct(
        private OpenApiFactoryInterface $decorated
    ) {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $cardEndpoint = '/api/communities/{communityId}/lists/{id}';

        $openApi = $this->decorated->__invoke($context);

        $paths = $openApi->getPaths();

        /** @var PathItem $path */
        $path = $openApi->getPaths()->getPath($cardEndpoint);

        /** @var Operation $operation */
        $operation = $path->getGet();
        /** @var \ApiPlatform\Core\OpenApi\Model\Response[] $responses */
        $responses = $operation->getResponses();

        /** @var \ArrayObject<string, MediaType> $content */
        $content = $responses[200]->getContent();

        foreach ($content as $contentType => $media) {
            $suffix = $contentType !== 'application/json' ? '.jsonld' : '';

            /** @var \ArrayObject<string, array> $schema */
            $schema = $media->getSchema();
            $schema['properties']['hydra:member']['items'] = [
                'oneOf' => [
                    ['$ref' => '#/components/schemas/CompanyCard.CompanyCardView' . $suffix],
                    ['$ref' => '#/components/schemas/MemberCard.MemberCardView' . $suffix],
                ],
            ];

            $media = $media->withSchema($schema);
            $content[$contentType] = $media;
        }

        $operation = $operation->addResponse($responses[200]->withContent($content), 200);
        $path = $path->withGet($operation);
        $paths->addPath($cardEndpoint, $path);

        return $openApi->withPaths($paths);
    }
}
