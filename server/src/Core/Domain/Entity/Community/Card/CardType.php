<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\Card;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

class CardType extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const MEMBER = 'member';
    public const COMPANY = 'company';
    public const EVENT = 'community_event';

    public static function readables(): array
    {
        return [
            self::MEMBER => 'Membre',
            self::COMPANY => 'Société',
            self::EVENT => 'Évènement',
        ];
    }
}
