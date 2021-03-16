<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Bridge\Vimeet\Nomenclature;

use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;

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

    public function export(Nomenclature $nomenclature, \SplFileObject $output): void
    {
        $output->setCsvControl(';');

        $rows = [];

        $languages = $this->defaultLanguages;
        if ($nomenclature->getCommunity() !== null) {
            $languages = $nomenclature->getCommunity()->getLanguages();
        }

        $rows[] = array_merge([''], $languages);

        foreach ($nomenclature->getRootTags() as $tag) {
            $this->exportTag($languages, $tag, 1, $rows);
        }

        $max = (int) max(array_map('count', $rows));

        foreach ($rows as $row) {
            $output->fputcsv(array_pad($row, $max, ''), ';');
        }
    }

    protected function exportTag(array $languages, NomenclatureTag $tag, int $level, array &$rows): void
    {
        $translations = [];
        foreach ($languages as $language) {
            $translations[$language] = $tag->getLabel($language);
        }

        $rows[] = array_merge(
            [
                'id' => $tag->getExternalId(),
            ],
            $level > 1 ? array_fill(0, $level - 1, '') : [],
            $translations
        );

        foreach ($tag->getChildren() as $child) {
            $this->exportTag($languages, $child, $level + 1, $rows);
        }
    }
}
