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
class EntityReferenceDoesNotExist extends Constraint
{
    public const REF_DOES_NOT_EXIST = 'ca2aafec-1542-4b55-8e5f-128e88e9f68a';

    /** @var array<string,string> */
    protected static $errorNames = [
        self::REF_DOES_NOT_EXIST => 'REF_DOES_NOT_EXIST',
    ];

    public string $message = 'The {{ value }} reference exists.';

    public ?string $code = null;

    /**
     * The entity class
     *
     * @phpstan-template T
     * @phpstan-var class-string<T>
     */
    public string $entity = self::class;

    public string $identityField = 'uuid';

    public ?string $currentField = null;

    public ?string $repositoryMethod = null;

    public function getDefaultOption(): string
    {
        return 'entity';
    }

    /**
     * @return array<string>
     */
    public function getRequiredOptions(): array
    {
        return ['entity'];
    }
}
