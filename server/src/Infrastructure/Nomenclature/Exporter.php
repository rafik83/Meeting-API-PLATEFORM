<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Nomenclature;

use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
use SplFileObject;

class Exporter
{
    /** @var string[] */
    private array $defaultLanguages;

    /**
     * @param string[] $defaultLanguages
     */
    public function __construct(array $defaultLanguages = ['en'])
    {
        $this->defaultLanguages = $defaultLanguages;
    }

    public function export(Nomenclature $nomenclature, SplFileObject $output): void
    {
        $output->setCsvControl(';');

        $languages = $this->defaultLanguages;
        if ($nomenclature->getCommunity() !== null) {
            $languages = $nomenclature->getCommunity()->getLanguages();
        }

        $output->fputcsv(array_merge(['id', 'parent'], $languages));

        foreach ($nomenclature->getRootTags() as $tag) {
            $this->exportTag($output, $languages, $tag);
        }
    }

    protected function exportTag(SplFileObject $output, array $languages, NomenclatureTag $tag): void
    {
        $translations = [];
        foreach ($languages as $language) {
            $translations[$language] = $tag->getLabel($language);
        }

        $output->fputcsv([
                'id' => $tag->getTag()->getExternalId(),
                'parent' => $tag->getParent() === null ? null : $tag->getParent()->getTag()->getExternalId(),
            ] + $translations);

        foreach ($tag->getChildren() as $child) {
            $this->exportTag($output, $languages, $child);
        }
    }
}
