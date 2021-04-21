<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account;

use Proximum\Vimeet365\Core\Application\Filesystem\AccountAvatarFilesystemInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;

class UploadAvatarCommandHandler
{
    private AccountAvatarFilesystemInterface $avatarFilesystem;

    public function __construct(AccountAvatarFilesystemInterface $avatarFilesystem)
    {
        $this->avatarFilesystem = $avatarFilesystem;
    }

    public function __invoke(UploadAvatarCommand $command): Account
    {
        $account = $command->account;

        $currentAvatar = $account->getAvatar();
        if ($currentAvatar !== null) {
            $this->avatarFilesystem->remove($currentAvatar);
        }

        $filename = null;
        if ($command->file !== null) {
            $filename = $this->avatarFilesystem->upload($account, $command->file);
        }

        $account->setAvatar($filename);

        return $account;
    }
}
