<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\Card;

use Proximum\Vimeet365\Api\Application\View\TagView;

class MemberCardView extends CardView
{
    /**
     * @param string[]  $languageCodes
     * @param TagView[] $goals
     */
    public function __construct(
        int $id,
        public string $firstName,
        public string $lastName,
        public ?string $picture,
        public ?string $companyName,
        public array $languageCodes,
        public ?string $jobPosition,
        public ?TagView $mainGoal,
        public ?TagView $secondaryGoal,
        public array $goals
    ) {
        parent::__construct('member', $id);
    }
}
