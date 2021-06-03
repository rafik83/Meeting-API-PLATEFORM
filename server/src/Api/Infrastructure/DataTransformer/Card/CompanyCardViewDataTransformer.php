<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataTransformer\Card;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Api\Application\View\Card\CardView;
use Proximum\Vimeet365\Api\Application\View\Card\CompanyCardView;
use Proximum\Vimeet365\Core\Application\Card\CompanyCard;
use Proximum\Vimeet365\Core\Application\Filesystem\Assets;
use Symfony\Component\Asset\Packages;

class CompanyCardViewDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private Packages $assetPackages
    ) {
    }

    /**
     * @param object|CompanyCard $object
     */
    public function transform($object, string $to, array $context = []): CardView
    {
        \assert($object instanceof CompanyCard);

        $company = $object->getCompany();

        $picture = null;
        if ($company->getLogo() !== null) {
            $picture = $this->assetPackages->getUrl($company->getLogo(), Assets::COMPANY_LOGOS);
        }

        return new CompanyCardView(
            $object->getId(),
            $picture,
            $company->getName(),
            substr($company->getActivity(), 0, 170)
        );
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CardView::class === $to && $data instanceof CompanyCard;
    }
}
