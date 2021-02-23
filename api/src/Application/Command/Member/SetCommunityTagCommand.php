<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Member;

use Proximum\Vimeet365\Application\ContextAwareMessageInterface;
use Proximum\Vimeet365\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Domain\Entity\Member;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\Member\CommunityStepConfigurationMatch;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\Member\CommunityStepExist;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Assert\Sequentially(constraints={
 *  @CommunityStepExist(),
 *  @CommunityStepConfigurationMatch()
 * })
 */
class SetCommunityTagCommand implements ContextAwareMessageInterface
{
    public int $step = 0;

    /**
     * @Assert\Valid()
     *
     * @var TagDto[]
     */
    public array $tags = [];

    /**
     * @Ignore
     */
    public Member $member;

    public function setContext(object $object): void
    {
        if (!$object instanceof Member) {
            throw new \RuntimeException('something went wrong');
        }

        $this->member = $object;
    }

    public function getMember(): Member
    {
        return $this->member;
    }
}
