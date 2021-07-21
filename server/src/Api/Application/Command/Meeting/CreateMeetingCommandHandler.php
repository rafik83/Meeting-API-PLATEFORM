<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Meeting;


use Proximum\Vimeet365\Common\Messenger\EventBusInterface;
use Proximum\Vimeet365\Core\Application\Event\Hubspot\AccountRegisteredEvent;
use Proximum\Vimeet365\Core\Application\Mail\AccountRegistrationMailerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Meeting;
use Proximum\Vimeet365\Core\Domain\Repository\MeetingRepositoryInterface;

class CreateMeetingCommandHandler
{
    private MeetingRepositoryInterface $meetingRepository;


    public function __construct(
        // récupérer current account connecté (  current user), repositoCommunity,repoMembre
        MeetingRepositoryInterface $meetingRepository) {
        $this->meetingRepository = $meetingRepository;

    }

    public function __invoke(CreateMeetingCommand $command): Meeting
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
        // getMembreFor(community) ==> creer objetMember et participantFrom
        // participantTo ==> repositoryMembre->find(Meeting $meeting)
//
            // Member,utilisateur connecté

        $meeting = new Meeting($command->startDate, $command->endDate,participant_from, participant_to, message,slots[]//dto slot);


        $this->meetingRepository->add($meeting);

        return $meeting;
    }
}
