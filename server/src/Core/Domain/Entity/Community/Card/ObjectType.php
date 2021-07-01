<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\Card;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

class ObjectType extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const MEMBER = 'user';
    public const COMPANY = 'company';
    public const EVENT = 'event';
    public const MEDIA = 'media';

    public static function readables(): array
    {
        return [
            self::MEMBER => 'Membre',
            self::COMPANY => 'Société',
            self::EVENT => 'Événement',
            self::MEDIA => 'Média',
        ];
    }
}
