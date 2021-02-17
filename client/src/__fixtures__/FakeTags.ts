import type { NomenclatureTag, Tag } from '../domain';

export const buildFakeTag = ({ name, priority, id }: Partial<Tag>): Tag => {
  return {
    priority,
    name: name || 'fakeTag',
    id: id || 666,
  };
};

export const buildFakeNomenclatureTag = (
  child?: Tag,
  parent?: Tag
): NomenclatureTag => {
  return {
    parent,
    tag: child || buildFakeTag({}),
  };
};
