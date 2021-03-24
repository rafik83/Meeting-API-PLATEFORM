<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Member;

use Proximum\Vimeet365\Application\ContextAwareMessageInterface;
use Proximum\Vimeet365\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Domain\Entity\Member;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\MemberGoal\GoalConfigurationMatch;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @GoalConfigurationMatch
 */
class SetGoalsCommand implements ContextAwareMessageInterface
{
    public int $goal;

    /**
     * @Assert\Valid()
     *
     * @var TagDto[]
     */
    public array $tags;

    /** @Ignore */
    public Member $member;

    public function setContext(object $object): void
    {
        if (!$object instanceof Member) {
            throw new \RuntimeException(
                sprintf('Must be called with a %s instance %s given', Member::class, \get_class($object))
            );
        }

        $this->member = $object;
    }
}
