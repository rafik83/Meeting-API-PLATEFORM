<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Account;

use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Domain\Repository\TagRepositoryInterface;

class UpdateProfileCommandHandler
{
    private TagRepositoryInterface $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function __invoke(UpdateProfileCommand $command): Account
    {
        $account = $command->getAccount();

        $jobPosition = $command->jobPosition;

        if ($jobPosition !== null) {
            $jobPosition = $this->tagRepository->getOneById($jobPosition);
        }

        $account->updateProfile(
            $jobPosition,
            $command->jobTitle,
            $command->languages,
            (string) $command->country,
            (string) $command->timezone
        );

        return $account;
    }
}
