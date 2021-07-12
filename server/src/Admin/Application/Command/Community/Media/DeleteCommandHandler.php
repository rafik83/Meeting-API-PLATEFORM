<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Media;

use Proximum\Vimeet365\Core\Domain\Repository\CommunityMediaRepositoryInterface;

class DeleteCommandHandler
{
    public function __construct(
        private CommunityMediaRepositoryInterface $mediaRepository
    ) {
    }

    public function __invoke(DeleteCommand $command): void
    {
        $this->mediaRepository->remove($command->getMedia());
    }
}
