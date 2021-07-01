<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Member;

use Proximum\Vimeet365\Api\Application\Security\CurrentAccountProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\MemberRepositoryInterface;

class JoinCommunityCommandHandler
{
    private CurrentAccountProviderInterface $currentAccountProvider;
    private CommunityRepositoryInterface $communityRepository;
    private MemberRepositoryInterface $memberRepository;

    public function __construct(
        CurrentAccountProviderInterface $currentAccountProvider,
        CommunityRepositoryInterface $communityRepository,
        MemberRepositoryInterface $memberRepository
    ) {
        $this->currentAccountProvider = $currentAccountProvider;
        $this->communityRepository = $communityRepository;
        $this->memberRepository = $memberRepository;
    }

    public function __invoke(JoinCommunityCommand $command): Member
    {
        $account = $this->currentAccountProvider->getAccount();

        if ($account === null) {
            throw new \RuntimeException('Unable to find the current account');
        }

        $community = $this->communityRepository->findOneById($command->community);

        if ($community === null) {
            // can't happen, the api is protected
            throw new \RuntimeException('Unable to retrieve the community');
        }

        $member = $community->join($account);

        $this->memberRepository->add($member);

        return $member;
    }
}
