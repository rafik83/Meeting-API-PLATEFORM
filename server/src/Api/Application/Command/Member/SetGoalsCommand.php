<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Member;

use Proximum\Vimeet365\Api\Application\ContextAwareMessageInterface;
use Proximum\Vimeet365\Api\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal\GoalBelongToMemberCommunity;
use Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal\HasEnoughTagSet;
use Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal\HasParentGoalConfigured;
use Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\MemberGoal\TagBelongToGoal;
use Proximum\Vimeet365\Common\Validator\Constraints\EntityReferenceExists;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @GoalBelongToMemberCommunity
 * @TagBelongToGoal
 * @HasParentGoalConfigured
 * @HasEnoughTagSet
 */
class SetGoalsCommand implements ContextAwareMessageInterface, MemberGoalCommandInterface
{
    /**
     * @EntityReferenceExists(entity=Goal::class, identityField="id")
     */
    public int $goal;

    /**
     * @Assert\Valid()
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
