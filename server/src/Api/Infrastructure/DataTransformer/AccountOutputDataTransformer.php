<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Api\Application\View\AccountView;
use Proximum\Vimeet365\Api\Application\View\CompanyView;
use Proximum\Vimeet365\Api\Application\View\MemberView;
use Proximum\Vimeet365\Core\Application\Filesystem\Assets;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Entity\Member;
use Symfony\Component\Asset\Packages;

class AccountOutputDataTransformer implements DataTransformerInterface
{
    private Packages $assetPackages;

    public function __construct(Packages $assetPackages)
    {
        $this->assetPackages = $assetPackages;
    }

    /**
     * {@inheritdoc}
     *
     * @param object|Account $data
     */
    public function transform($data, string $to, array $context = []): AccountView
    {
        if (!$data instanceof Account) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', Account::class, \get_class($data))
            );
        }

        $avatar = null;
        if ($data->getAvatar() !== null) {
            $avatar = $this->assetPackages->getUrl($data->getAvatar(), Assets::ACCOUNT_AVATAR);
        }

        $company = null;
        if ($data->getCompany() !== null) {
            $company = CompanyView::createFromCompany($data->getCompany(), $this->assetPackages->getPackage(Assets::COMPANY_LOGOS));
        }

        return new AccountView(
            (int) $data->getId(),
            $data->getEmail(),
            $data->getFirstName(),
            $data->getLastName(),
            $data->getAcceptedTermsAndConditionAt(),
            $avatar,
            $company,
            $data->getMembers()->map(fn (Member $member) => new MemberView((int) $member->getId(), $member->getJoinedAt(), $member->getCommunity()->getId()))->getValues(),
            $data->hasBeenValidated()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return AccountView::class === $to && $data instanceof Account;
    }
}
