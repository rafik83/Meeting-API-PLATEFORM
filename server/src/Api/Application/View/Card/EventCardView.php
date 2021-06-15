<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\Card;

use Proximum\Vimeet365\Api\Application\View\TagView;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\EventType;

class EventCardView extends CardView
{
    /**
     * @param TagView[] $tags
     */
    public function __construct(
        int $id,
        public string $picture,
        public string $name,
        public \DateTimeImmutable $startDate,
        public \DateTimeImmutable $endDate,
        public EventType $eventType,
        public string $registerUrl,
        public string $findOutMoreUrl,
        public array $tags
    ) {
        parent::__construct(CardType::get(CardType::EVENT), $id);
    }
}
