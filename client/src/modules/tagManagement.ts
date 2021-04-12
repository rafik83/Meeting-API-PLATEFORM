import type { Nomenclature, NomenclatureTag, Tag } from '../domain';

export const getTagsMaxPriority = (tags: Array<Tag>): number => {
  const result = Math.max.apply(
    Math,
    tags.map((item) => item.priority)
  );

  return result;
};

export const updatePriorities = (
  selectedTag: Tag,
  tags: Array<Tag>
): Array<Tag> => {
  const tagsMaxPriority = getTagsMaxPriority(tags);

  return tags.map((tag) => {
    if (!selectedTag.priority) {
      if (tag.id === selectedTag.id) {
        return {
          ...tag,
          priority: tagsMaxPriority ? tagsMaxPriority + 1 : 1,
        };
      }

      return tag;
    }

    if (tag.id === selectedTag.id) {
      return {
        ...tag,
        priority: null,
      };
    }

    if (tag.priority >= selectedTag.priority) {
      return {
        ...tag,
        priority: tag.priority - 1,
      };
    }

    return tag;
  });
};

export const filterTagsWithNoPriorities = (tags: Array<Tag>) => {
  return tags.filter((item) => item.priority);
};

export const getTagsWithPriorityCount = (tags: Array<Tag>): number => {
  return filterTagsWithNoPriorities(tags).length;
};

export const setTagPriorityToNullIfNotDefined = (tags: Array<Tag>) => {
  return tags.map((tag) => {
    return {
      ...tag,
      priority: tag.priority || null,
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

export const getTagsFromNomenclature = (
  nomenclaturesTags: Nomenclature
): Array<Tag> => {
  return nomenclaturesTags.tags.map((item) => {
    return item.tag;
  });
};

export type TreeItem = {
  children: TreeItem[];
  tag: Tag;
  parent: Tag | null;
};

export const buildTagTree = (nomenclature: Nomenclature): Array<TreeItem> => {
  const tree: Array<TreeItem> = [];

  nomenclature.tags.forEach((currentNomenclatureTag: NomenclatureTag) => {
    let existingTreeItem = tree.find((treeItem) => {
      return treeItem.tag.id === currentNomenclatureTag.tag.id;
    });

    if (!existingTreeItem) {
      const treeItem: TreeItem = {
        children: [],
        tag: currentNomenclatureTag.tag,
        parent: null,
      };
      tree.push(treeItem);
      existingTreeItem = treeItem;
    }

    existingTreeItem.parent = currentNomenclatureTag.parent;

    if (currentNomenclatureTag.parent) {
      let parentTreeItem = tree.find((treeItem) => {
        return treeItem.tag.id === currentNomenclatureTag.parent.id;
      });

      if (!parentTreeItem) {
        parentTreeItem = {
          children: [],
          tag: currentNomenclatureTag.parent,
          parent: null,
        };
        tree.push(parentTreeItem);
      }

      parentTreeItem.children.push(existingTreeItem);
    }
  });

  return tree;
};
