import type { TagTreeItem } from '../domain';
import { buildFakeTag } from './FakeTags';

export const buildFakeTreeItem = ({
  children,
  tag,
  parent,
}: Partial<TagTreeItem>): TagTreeItem => {
  return {
    children: children && children.length > 0 ? children : [],
    tag: tag || buildFakeTag({}),
    parent: parent,
  };
};
