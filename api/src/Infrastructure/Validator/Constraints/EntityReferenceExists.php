<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Check an entity reference exists according to given identifier field.
 *
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class EntityReferenceExists extends Constraint
{
    public const REF_DOES_NOT_EXIST = 'd3ead236-bee1-4e1d-ad41-2b2d7c303dc3';

    /**
     * @var array<string, string>
     */
    protected static $errorNames = [
        self::REF_DOES_NOT_EXIST => 'REF_DOES_NOT_EXIST',
    ];

    public string $message = 'The {{ value }} reference does not exist.';

    public ?string $code = null;

    /**
     * The entity class
     *
     * @phpstan-template T
     * @phpstan-var class-string<T>
     */
    public string $entity = self::class;

    public string $identityField = 'uuid';

    public ?string $repositoryMethod = null;

    public function getDefaultOption(): ?string
    {
        return 'entity';
    }

    /**
     * @return string[]
     */
    public function getRequiredOptions(): array
    {
        return ['entity'];
    }
}
