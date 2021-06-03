<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\Card;

class CompanyCardView extends CardView
{
    public function __construct(
        int $id,
        public ?string $picture,
        public string $name,
        public string $activity,
    ) {
        parent::__construct('company', $id);
    }
}
