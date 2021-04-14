<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Member;

use Proximum\Vimeet365\Application\ContextAwareMessageInterface;
use Proximum\Vimeet365\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Domain\Entity\Member;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\EntityReferenceExists;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\MemberGoal\GoalBelongToMemberCommunity;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\MemberGoal\TagBelongToGoal;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\MemberGoal\TagMustBeSetBeforeRank;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @GoalBelongToMemberCommunity
 * @TagBelongToGoal
 * @TagMustBeSetBeforeRank
 */
class RankGoalsCommand implements ContextAwareMessageInterface, MemberGoalCommandInterface
{
    /**
     * @EntityReferenceExists(entity=Goal::class, identityField="id")
     */
    public int $goal;

    /**
     * @Assert\Valid()
     * @Assert\Count(min=0, max=3)
     *
     * @var TagDto[]
     */
    public array $tags;

    /** @Ignore */
    private Member $member;

    public function setContext(object $object): void
    {
        if (!$object instanceof Member) {
            throw new \RuntimeException(
                sprintf('Must be called with a %s instance %s given', Member::class, \get_class($object))
            );
        }

        $this->member = $object;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getGoal(): int
    {
        return $this->goal;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}
