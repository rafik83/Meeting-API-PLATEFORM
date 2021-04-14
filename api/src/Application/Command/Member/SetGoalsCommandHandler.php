<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Member;

use Proximum\Vimeet365\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Domain\Entity\Community\Goal as CommunityGoal;
use Proximum\Vimeet365\Domain\Entity\Member;
use Proximum\Vimeet365\Domain\Repository\TagRepositoryInterface;

class SetGoalsCommandHandler
{
    private TagRepositoryInterface $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function __invoke(SetGoalsCommand $command): Member
    {
        $member = $command->getMember();
        $community = $member->getCommunity();

        /** @var CommunityGoal $goal */
        $goal = $community->getGoals()->filter(fn (CommunityGoal $communityGoal): bool => $communityGoal->getId() === $command->getGoal())->first();

        $existingMemberGoals = $member->getGoals()->filter(fn (Member\Goal $memberGoal): bool => $memberGoal->getCommunityGoal()->getId() === $command->getGoal());

        foreach ($existingMemberGoals as $existingMemberGoal) {
            $member->getGoals()->removeElement($existingMemberGoal);
        }

        $tagsId = array_map(fn (TagDto $tagDto): int => $tagDto->id, $command->getTags());
        $tags = $this->tagRepository->findByIds($tagsId);

        foreach ($command->getTags() as $tagDto) {
            new Member\Goal($member, $goal, $tags[$tagDto->id], $tagDto->priority);
        }

        return $member;
    }
}
