<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Card;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

class Sorting extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const ALPHABETICAL = 'alphabetical';
    public const DATE = 'date';

    public static function readables(): array
    {
        return [
            self::ALPHABETICAL => 'Ordre Alphabétique',
            self::DATE => 'Date de création',
        ];
    }
}
