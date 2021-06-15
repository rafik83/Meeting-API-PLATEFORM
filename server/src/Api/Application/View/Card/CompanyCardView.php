<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\Card;

use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;

class CompanyCardView extends CardView
{
    public function __construct(
        int $id,
        public ?string $picture,
        public string $name,
        public string $activity,
    ) {
        parent::__construct(CardType::get(CardType::COMPANY), $id);
    }
}
