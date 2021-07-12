<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\Media;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

class MediaType extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const PRESS = 'press';
    public const INTERVIEW = 'interview';
    public const REPLAY = 'replay';

    public static function readables(): array
    {
        return [
            self::PRESS => 'Presse',
            self::INTERVIEW => 'Interview',
            self::REPLAY => 'Replay',
        ];
    }
}
