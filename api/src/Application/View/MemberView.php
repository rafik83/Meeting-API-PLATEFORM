<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

class MemberView
{
    public int $id;
    public \DateTimeImmutable $joinedAt;
    public ?CommunityStepView $currentQualificationStep;

    /** @var NomenclatureTagsView[] */
    public array $tagsByNomenclature;

    /**
     * @param NomenclatureTagsView[] $tagsByNomenclature
     */
    public function __construct(int $id, \DateTimeImmutable $joinedAt, ?CommunityStepView $currentQualificationStep, array $tagsByNomenclature)
    {
        $this->id = $id;
        $this->joinedAt = $joinedAt;
        $this->currentQualificationStep = $currentQualificationStep;
        $this->tagsByNomenclature = $tagsByNomenclature;
    }
}
