<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Meeting;

use Proximum\Vimeet365\Api\Application\Security\CurrentAccountProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Meeting;
use Proximum\Vimeet365\Core\Infrastructure\Repository\AccountRepository;
use Proximum\Vimeet365\Core\Infrastructure\Repository\CommunityRepository;
use Proximum\Vimeet365\Core\Infrastructure\Repository\MeetingRepository;
use Proximum\Vimeet365\Core\Infrastructure\Repository\MemberRepository;

class CreateMeetingCommandHandler
{
    private MeetingRepository $meetingRepository;
    private CurrentAccountProviderInterface $currentAccountProvider;
    private CommunityRepository $communityRepository;
    private AccountRepository  $accountRepository;
    private MemberRepository $memberRepository;

    public function __construct(
        MemberRepository $memberRepository,
        AccountRepository $accountRepository,
        MeetingRepository $meetingRepository,
        CurrentAccountProviderInterface $currentAccountProvider,
        CommunityRepository $communityRepository
    ) {
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

        $community = $this->communityRepository->findOneById($command->community);
        if ($community == null) {
            throw new \RuntimeException('unable to find the community');
        }

        $memberFrom = $community->join($account); 
        if ($memberFrom == null) {
            throw new \RuntimeException('unable to find Member');
        }

        $memberTo = $this->memberRepository->findOneById($command->participantTo);
        if ($memberTo == null) {
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
