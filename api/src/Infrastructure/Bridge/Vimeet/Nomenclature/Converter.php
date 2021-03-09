<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Bridge\Vimeet\Nomenclature;

use SplFileObject;

class Converter
{
    public function convert(SplFileObject $input, SplFileObject $output): void
    {
        $input->setCsvControl(';');
        $input->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

        $output->setCsvControl(';');

        $languages = array_filter((array) $input->fgetcsv());
        $parents = [];
        $previous = null;

        $output->fputcsv(array_merge(['id', 'parent'], $languages));

        while ($row = $input->fgetcsv()) {
            $id = array_shift($row);
            $level = 0;
            while (current($row) === '') {
                array_shift($row);
                ++$level;
            }

            $labels = (array) array_combine(
                $languages,
                array_map(
                    static fn (string $input): string => utf8_encode($input),
                    \array_slice($row, 0, \count($languages))
                )
            );

            if ($previous !== null) {
                if ($previous['level'] === $level) {
                    $parents[$level] = $id;
                } elseif ($previous['level'] < $level) {
                    $parents[$level - 1] = $previous['id'];
                    $parents[$level] = $id;
                } else {
                    $parents[$level] = null;
                }
            }

            $item = ['id' => $id, 'level' => $level, 'languages' => $labels, 'parent' => $parents[$level - 1] ?? null];
            $previous = $item;

            $output->fputcsv(array_merge([$item['id'], $item['parent'] ?? ''], $labels));
        }
    }
}
