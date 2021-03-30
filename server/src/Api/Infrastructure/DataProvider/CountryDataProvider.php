<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Proximum\Vimeet365\Api\Application\View\CountryView;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Intl\Countries;

final class CountryDataProvider implements ItemDataProviderInterface, CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return CountryView::class === $resourceClass;
    }

    /**
     * @return CountryView[]
     */
    public function getCollection(string $resourceClass, ?string $operationName = null): array
    {
        $countries = array_map(static fn (string $code) => new CountryView($code, Countries::getName($code)), Countries::getCountryCodes());

        usort($countries, static fn (CountryView $a, CountryView $b): int => $a->name <=> $b->name);

        return $countries;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): CountryView
    {
        if (!\is_string($id)) {
            throw new BadRequestHttpException('Code not valid');
        }

        if (!Countries::exists($id)) {
            throw new NotFoundHttpException('Code not found');
        }

        return new CountryView($id, Countries::getName($id));
    }
}
