<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Api\Application\View\CompanyView;
use Proximum\Vimeet365\Core\Application\Filesystem\Assets;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Symfony\Component\Asset\Packages;

class CompanyOutputDataTransformer implements DataTransformerInterface
{
    private Packages $assetPackages;

    public function __construct(Packages $assetPackages)
    {
        $this->assetPackages = $assetPackages;
    }

    /**
     * {@inheritdoc}
     *
     * @param object|Company $data
     */
    public function transform($data, string $to, array $context = []): CompanyView
    {
        if (!$data instanceof Company) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', Company::class, \get_class($data))
            );
        }

        return CompanyView::createFromCompany($data, $this->assetPackages->getPackage(Assets::COMPANY_LOGOS));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CompanyView::class === $to && $data instanceof Company;
    }
}
