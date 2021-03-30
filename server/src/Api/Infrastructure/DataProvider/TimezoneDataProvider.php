<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Proximum\Vimeet365\Api\Application\View\TimezoneView;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Intl\Timezones;

final class TimezoneDataProvider implements ItemDataProviderInterface, CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return TimezoneView::class === $resourceClass;
    }

    /**
     * @return TimezoneView[]
     */
    public function getCollection(string $resourceClass, ?string $operationName = null): array
    {
        $timezones = array_map(static fn (string $code) => new TimezoneView($code, Timezones::getName($code)), Timezones::getIds());

        usort($timezones, static fn (TimezoneView $a, TimezoneView $b): int => $a->name <=> $b->name);

        return $timezones;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): TimezoneView
    {
        if (!\is_string($id)) {
            throw new BadRequestHttpException('Code not valid');
        }

        if (!Timezones::exists($id)) {
            throw new NotFoundHttpException('Code not found');
        }

        return new TimezoneView($id, Timezones::getName($id));
    }
}
