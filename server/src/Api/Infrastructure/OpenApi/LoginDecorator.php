<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\OpenApi;
use ArrayObject;

final class LoginDecorator implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Credentials'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'johndoe@example.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'apassword',
                ],
            ],
        ]);

        $pathItem = new PathItem(
            'Login',
            null,
            null,
            null,
            null,
            new Operation(
                'postCredentialsItem',
                [],
                [
                    '204' => [
                        'description' => 'The user was login successfully (Cookie set in headers)',
                        'headers' => [
                            'set-cookie' => [
                                'description' => 'The cookie that need to be sent to the next requests',
                            ],
                        ],
                    ],
                    '401' => [
                        'description' => 'Invalid credentials or user not found',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'error' => [
                                            'type' => 'string',
                                            'example' => 'Username could not be found.',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'Login the user with username & password',
                'Login the user with username & password',
                null,
                [],
                new RequestBody(
                    'Request body descrption',
                    new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials',
                            ],
                        ],
                    ])
                )
            )
        );
        $openApi->getPaths()->addPath('/api/login', $pathItem);

        return $openApi;
    }
}
