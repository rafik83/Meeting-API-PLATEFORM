<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Proximum\Vimeet365\Api\Application\View\LanguageView;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Intl\Languages;

final class LanguageDataProvider implements ItemDataProviderInterface, CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var string[] */
    private array $languages;

    /**
     * @param string[] $languages
     */
    public function __construct(array $languages = [])
    {
        $this->languages = $languages;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return LanguageView::class === $resourceClass;
    }

    /**
     * @return LanguageView[]
     */
    public function getCollection(string $resourceClass, ?string $operationName = null): array
    {
        $languages = Languages::getLanguageCodes();

        if (\count($this->languages) !== 0) {
            $languages = $this->languages;
        }

        $languages = array_map(static fn (string $code) => new LanguageView($code, Languages::getName($code)), $languages);

        usort($languages, static fn (LanguageView $a, LanguageView $b): int => $a->name <=> $b->name);

        return $languages;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): LanguageView
    {
        if (!\is_string($id)) {
            throw new BadRequestHttpException('Code not valid');
        }

        if (!Languages::exists($id)) {
            throw new NotFoundHttpException('Code not found');
        }

        if (\count($this->languages) !== 0 && !\in_array($id, $this->languages, true)) {
            throw new NotFoundHttpException('Code not found');
        }

        return new LanguageView($id, Languages::getName($id));
    }
}
