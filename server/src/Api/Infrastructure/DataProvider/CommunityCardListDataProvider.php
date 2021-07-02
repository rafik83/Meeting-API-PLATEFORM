<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataProvider;

use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\SubresourceDataProviderInterface;
use Proximum\Vimeet365\Api\Infrastructure\Security\SymfonyUser;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class CommunityCardListDataProvider implements SubresourceDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(
        private CommunityRepositoryInterface $communityRepository,
        private Security $security
    ) {
    }

    /**
     * @return CardList[]
     */
    public function getSubresource(
        string $resourceClass,
        array $identifiers,
        array $context,
        string $operationName = null
    ): array {
        $community = $this->communityRepository->findOneById($identifiers['id']['id']);
        if ($community === null) {
            throw new NotFoundHttpException(sprintf('Community "%s" not found.', $identifiers['id']['id']));
        }

        /** @var SymfonyUser|null $user */
        $user = $this->security->getUser();
        $member = $user?->getAccount()->getMemberFor($community);

        return $community->getPublishedCardLists($member)->getValues();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === CardList::class;
    }
}
