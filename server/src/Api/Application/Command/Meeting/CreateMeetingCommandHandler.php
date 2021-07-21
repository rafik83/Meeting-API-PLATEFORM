<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Meeting;

use Proximum\Vimeet365\Api\Application\Security\CurrentAccountProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Meeting;
use Proximum\Vimeet365\Core\Domain\Repository\AccountRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\MeetingRepositoryInterface;
use Proximum\Vimeet365\Core\Domain\Repository\MemberRepositoryInterface;

class CreateMeetingCommandHandler
{
    private MeetingRepositoryInterface $meetingRepository;
    private CurrentAccountProviderInterface $currentAccountProvider;
    private CommunityRepositoryInterface $communityRepository;
    private AccountRepositoryInterface  $accountRepository;
    private MemberRepositoryInterface $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository, AccountRepositoryInterface $accountRepository, MeetingRepositoryInterface $meetingRepository, CurrentAccountProviderInterface $currentAccountProvider, CommunityRepositoryInterface $communityRepository)
    {
        // récupérer account ,current user connecté , repositoCommunity,repoMembre
        $this->meetingRepository = $meetingRepository;
        $this->currentAccountProvider = $currentAccountProvider;
        $this->communityRepository = $communityRepository;
        $this->accountRepository = $accountRepository;
        $this->memberRepository = $memberRepository;
    }

    public function __invoke(CreateMeetingCommand $command): Meeting
    {
        $account = $this->currentAccountProvider->getAccount();
        if ($account === null) {
            throw new \RuntimeException('Unable to find the current account');
        }
        $memberTo = $this->memberRepository->findOneById($command->participantTo);
        if ($memberTo == null) {
            throw new \RuntimeException('unable to find Member');
        }
        $community = $this->communityRepository->findOneById($command->community);
        if ($community == null) {
            throw new \RuntimeException('unable to find the community');
        }
        $memberFrom = $account->getMemberFor($community);
        if ($memberFrom == null) {
            throw new \RuntimeException('unable to find Member');
        }

        $meeting = new Meeting($memberFrom, $memberTo, $command->message);

        foreach ($command->slots as $slot) {
            $meeting->addSlot($slot->startDate, $slot->endDate);
        }
        $this->meetingRepository->add($meeting);

        return $meeting;
    }
}
