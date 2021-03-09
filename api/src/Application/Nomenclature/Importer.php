<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Nomenclature;

use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Domain\Entity\Tag;
use Proximum\Vimeet365\Domain\Repository\NomenclatureTagRepositoryInterface;
use Proximum\Vimeet365\Domain\Repository\TagRepositoryInterface;

class Importer
{
    private TagRepositoryInterface $tagRepository;
    private NomenclatureTagRepositoryInterface $nomenclatureTagRepository;

    private array $data = [];

    /** @var Tag[] */
    private array $tagsByExternalId = [];

    /** @var Tag[] */
    private array $tagsByRow = [];

    public function __construct(
        TagRepositoryInterface $tagRepository,
        NomenclatureTagRepositoryInterface $nomenclatureTagRepository
    ) {
        $this->tagRepository = $tagRepository;
        $this->nomenclatureTagRepository = $nomenclatureTagRepository;
    }

    public function import(Nomenclature $nomenclature, \SplFileObject $file): void
    {
        $this->configureFile($file);

        $languages = \array_slice((array) $file->fgetcsv(), 2, null, true);

        $this->data = [];
        $this->tagsByExternalId = [];
        $this->tagsByRow = [];

        /** @var array<int, string|int> $row */
        foreach ($file as $i => $row) {
            if ($i === 0) {
                continue;
            }

            $id = $this->generateExternalId((string) $row[0]);
            $parent = $this->findParent((string) $row[1]);

            /** @var array<string, string> $labels */
            $labels = (array) array_combine($languages, \array_slice($row, 2));

            $tag = $this->getTagByExternalId($id, $labels);

            $this->tagsByExternalId[$id] = $tag;
            $this->tagsByRow[$i - 1] = $tag;

            $this->data[] = ['id' => $id, 'tag' => $tag, 'parent' => $parent, 'translations' => $labels];
        }

        $nomenclature->getTags()->clear();

        foreach ($this->data as $row) {
            $nomenclatureTag = $nomenclature->addTag($row['tag'], $row['parent']);
            $nomenclatureTag->setExternalId($row['id']);
            foreach ($row['translations'] as $locale => $label) {
                $nomenclatureTag->setLabel($label, $locale);
            }
        }
    }

    private function generateExternalId(string $externalId): string
    {
        if ($externalId !== '') {
            return $externalId;
        }

        return uniqid('t', false);
    }

    private function findParent(string $parentId): ?Tag
    {
        if ($parentId === '') {
            return null;
        }

        if (str_starts_with($parentId, '@')) {
            // if the parent id start with an `@` it's an alias to an existing row in the file
            $parentRow = ((int) substr($parentId, 1)) - 2;
            if (!\array_key_exists($parentRow, $this->data)) {
                // throw exception parent not found
                throw new \RuntimeException(sprintf('Row %d not found in the file', $parentRow));
            }

            return $this->tagsByRow[$parentRow];
        }

        if (!\array_key_exists($parentId, $this->tagsByExternalId)) {
            // throw exception parent not found
            throw new \RuntimeException(sprintf('Row with id %s not found in the file', $parentId));
        }

        return $this->tagsByExternalId[$parentId];
    }

    private function getTagByExternalId(string $id, array $labels): Tag
    {
        if (\array_key_exists($id, $this->tagsByExternalId)) {
            return $this->tagsByExternalId[$id];
        }

        /** @var Tag|null $tag */
        $tag = $this->tagRepository->findOneByExternalId($id);
        if ($tag !== null) {
            return $tag;
        }

        /** @var NomenclatureTag|null $nomenclatureTag */
        $nomenclatureTag = $this->nomenclatureTagRepository->findOneByExternalId($id);
        if ($nomenclatureTag !== null) {
            return $nomenclatureTag->getTag();
        }

        $tag = new Tag($id);
        foreach ($labels as $locale => $label) {
            $tag->setLabel($label, $locale);
        }

        return $tag;
    }

    private function configureFile(\SplFileObject $file): void
    {
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);
        $file->setCsvControl(';');
    }
}
