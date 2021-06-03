<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\DataFixtures;

use Elao\Enum\EnumInterface;
use Faker\Provider\Base;

class EnumProvider extends Base
{
    public static function enum(string $class, string $value): EnumInterface
    {
        if (!is_subclass_of($class, EnumInterface::class, true)) {
            throw new \InvalidArgumentException(
                sprintf('Expected an %s classname, got %s', EnumInterface::class, $class)
            );
        }

        return $class::get($value);
    }
}
