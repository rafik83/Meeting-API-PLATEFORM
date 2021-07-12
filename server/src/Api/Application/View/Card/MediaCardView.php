<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\Card;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media\MediaType;

class MediaCardView extends CardView
{
    public function __construct(
        int $id,
        public ?string $video,
        public string $name,
        public string $description,
        public MediaType $mediaType,
        public ?string $ctaLabel,
        public ?string $ctaUrl
    ) {
        parent::__construct(CardType::get(CardType::MEDIA), $id);
    }
}
