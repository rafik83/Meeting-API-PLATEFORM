<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\Event;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

class EventType extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const ONLINE = 'online';
    public const HYBRID = 'hybrid';
    public const FACE_TO_FACE = 'face-to-face';

    public static function readables(): array
    {
        return [
            self::ONLINE => 'Online',
            self::HYBRID => 'Hybride',
            self::FACE_TO_FACE => 'Physique',
        ];
    }
}
