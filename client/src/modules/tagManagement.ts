import type { NomenclatureTag, Tag } from '../domain';

export const getTagsMaxPriority = (
  nomenclatureTags: Array<NomenclatureTag>
): number => {
  const result = Math.max.apply(
    Math,
    nomenclatureTags.map((item) => item.tag.priority)
  );

  return result;
};

export const updatePriorities = (
  selectedTag: Tag,
  nomenclatureTags: Array<NomenclatureTag>
): Array<NomenclatureTag> => {
  const tagsMaxPriority = getTagsMaxPriority(nomenclatureTags);

  return nomenclatureTags.map((nomenclatureTag) => {
    const { tag } = nomenclatureTag;
    if (!selectedTag.priority) {
      if (nomenclatureTag.tag.id === selectedTag.id) {
        return {
          ...nomenclatureTag,
          tag: {
            ...tag,
            priority: tagsMaxPriority ? tagsMaxPriority + 1 : 1,
          },
        };
      }

      return nomenclatureTag;
    }

    if (tag.id === selectedTag.id) {
      return {
        ...nomenclatureTag,
        tag: {
          ...tag,
          priority: null,
        },
      };
    }

    if (tag.priority >= selectedTag.priority) {
      return {
        ...nomenclatureTag,
        tag: {
          ...tag,
          priority: tag.priority - 1,
        },
      };
    }

    return nomenclatureTag;
  });
};

export const filterTagsWithNoPriorities = (
  nomenclatureTags: Array<NomenclatureTag>
) => {
  return nomenclatureTags.filter((item) => item.tag.priority);
};

export const getTagsWithPriorityCount = (
  nomenclatureTags: Array<NomenclatureTag>
): number => {
  return filterTagsWithNoPriorities(nomenclatureTags).length;
};

export const setTagPriorityToNullIfNotDefined = (
  nomenclatureTags: Array<NomenclatureTag>
) => {
  return nomenclatureTags.map((item) => {
    const { tag } = item;
    return {
      ...item,
      tag: {
        ...tag,
        priority: tag.priority || null,
      },
    };
  });
};

export const getTagsFromNomenclatureTags = (
  nomenclatureTags: Array<NomenclatureTag>
): Array<Tag> => {
  return nomenclatureTags.map((nomenclatureTag) => {
    return nomenclatureTag.tag;
  });
};

//
