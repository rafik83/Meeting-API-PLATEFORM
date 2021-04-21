<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account;

use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class UploadAvatarCommand
{
    public Account $account;

    /**
     * @Assert\Image(maxSize="1M", mimeTypes={"image/png", "image/jpeg"})
     */
    public ?UploadedFile $file;

    public function __construct(Account $account, ?UploadedFile $logo)
    {
        $this->account = $account;
        $this->file = $logo;
    }
}
