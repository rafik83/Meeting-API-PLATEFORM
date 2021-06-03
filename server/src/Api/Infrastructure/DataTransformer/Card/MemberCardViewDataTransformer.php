<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataTransformer\Card;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Api\Application\View\Card\CardView;
use Proximum\Vimeet365\Api\Application\View\Card\MemberCardView;
use Proximum\Vimeet365\Api\Application\View\Goal\MemberGoalTagView;
use Proximum\Vimeet365\Api\Application\View\TagView;
use Proximum\Vimeet365\Core\Application\Card\MemberCard;
use Proximum\Vimeet365\Core\Application\Filesystem\Assets;
use Proximum\Vimeet365\Core\Domain\Entity\Member\Goal;
use Symfony\Component\Asset\Packages;

class MemberCardViewDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private Packages $assetPackages
    ) {
    }

    /**
     * @param object|MemberCard $object
     */
    public function transform($object, string $to, array $context = []): CardView
    {
        \assert($object instanceof MemberCard);

        $member = $object->getMember();
        $account = $member->getAccount();

        $avatar = null;
        if ($account->getAvatar() !== null) {
            $avatar = $this->assetPackages->getUrl($account->getAvatar(), Assets::ACCOUNT_AVATAR);
        }

        $mainGoals = $member->getMainGoals();
        /** @var Goal|null $mainGoal */
        $mainGoal = $mainGoals->get(0);

        /** @var Goal|null $mainGoal */
        $secondaryGoal = $mainGoals->get(1);

        $refinedGoals = [];
        if ($mainGoal !== null) {
            $refinedGoals = $member->getRefinedGoals($mainGoal)
                ->map(fn (Goal $goal): TagView => MemberGoalTagView::create($goal)->tag)
                ->slice(0, 3);
        }

        return new MemberCardView(
            $object->getId(),
            $account->getFirstName(),
            $account->getLastName(),
            $avatar,
            $account->getCompany()?->getName(),
            $account->getLanguages(),
            $account->getJobPosition()?->getLabel(),
            $mainGoal !== null ? MemberGoalTagView::create($mainGoal)->tag : null,
            $secondaryGoal !== null ? MemberGoalTagView::create($secondaryGoal)->tag : null,
            $refinedGoals
        );
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CardView::class === $to && $data instanceof MemberCard;
    }
}
