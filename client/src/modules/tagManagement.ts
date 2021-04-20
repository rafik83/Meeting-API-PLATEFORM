import type { MemberGoal, Nomenclature, Tag, TagTreeItem } from '../domain';

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

export const getTagsFromNomenclature = (
  nomenclaturesTags: Nomenclature
): Array<Tag> => {
  return nomenclaturesTags.tags.map((item) => {
    return item;
  });
};

export const buildTagTree = (tags: Array<Tag>): Array<TagTreeItem> => {
  const tree: Array<TagTreeItem> = [];

  tags.forEach((currentTag: Tag) => {
    let existingTreeItem = tree.find((treeItem) => {
      return treeItem.tag.id === currentTag.id;
    });

    if (!existingTreeItem) {
      const treeItem: TagTreeItem = {
        children: [],
        tag: currentTag,
        parent: null,
      };
      tree.push(treeItem);
      existingTreeItem = treeItem;
    }

    existingTreeItem.parent = currentTag.parent;

    if (currentTag.parent) {
      let parentTreeItem = tree.find((treeItem) => {
        return treeItem.tag.id === currentTag.parent.id;
      });

      if (!parentTreeItem) {
        parentTreeItem = {
          children: [],
          tag: currentTag.parent,
          parent: null,
        };
        tree.push(parentTreeItem);
      }

      parentTreeItem.children.push(existingTreeItem);
    }
  });

  return tree;
};

export const filterTagTree = (
  subTree: TagTreeItem,
  tags: Array<Tag>
): Array<TagTreeItem> => {
  let result = [];
  subTree.children.forEach((child) => {
    const itemExists =
      tags.findIndex((tag) => {
        return child.tag.id === tag.id;
      }) !== -1;

    if (itemExists) {
      result = [...result, child];
    }
    if (child.children.length > 0) {
      result = [...result, ...filterTagTree(child, tags)];
    }
  });

  return result;
};

export const getFirstLevelTreeItems = (tree: Array<TagTreeItem>) => {
  return tree.filter((treeItem) => {
    return !treeItem.parent;
  });
};

export type GroupedTreeItem = {
  parent: Tag;
  children: Array<Tag>;
};

export const groupTreeItemByParent = (
  tree: Array<TagTreeItem>
): Array<GroupedTreeItem> => {
  const groupedTreeItems: Array<GroupedTreeItem> = [];

  tree.forEach((treeItem) => {
    if (!treeItem.parent) {
      return;
    }
    const foundGroupedTreeItem = groupedTreeItems.find(
      (item) => item.parent.id === treeItem.parent.id
    );

    if (foundGroupedTreeItem) {
      foundGroupedTreeItem.children.push(treeItem.tag);
    } else {
      const newGroupedTagItem: GroupedTreeItem = {
        parent: treeItem.parent,
        children: [treeItem.tag],
      };

      groupedTreeItems.push(newGroupedTagItem);
    }
  });

  return groupedTreeItems;
};

export const getTagsFromMemberGoal = (memberGoal: MemberGoal): Array<Tag> => {
  return memberGoal.tags.map((item) => {
    return item.tag;
  });
};

export const createGroupOfTreeItemsByParent = (
  treeItems: Array<TagTreeItem>,
  selectedTags: Array<Tag>
): Array<GroupedTreeItem> => {
  let result: Array<GroupedTreeItem> = [];

  treeItems.forEach((treeItem) => {
    const filteredItems = filterTagTree(treeItem, selectedTags);
    const group = groupTreeItemByParent(filteredItems);
    result = [...result, ...group];
  });

  return result;
};

export const updatePrioritiesWithinGroupedTreeItems = (
  tags: Array<Tag>,
  groups: Array<GroupedTreeItem>
): Array<GroupedTreeItem> => {
  const _groups = [...groups];
  _groups.forEach((group) => {
    group.children.forEach((item) => {
      const foundChild = tags.find((tag) => tag.id === item.id);
      if (foundChild) {
        item.priority = foundChild.priority;
      } else {
        item.priority = null;
      }
    });
  });

  return _groups;
};
