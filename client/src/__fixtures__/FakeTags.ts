import type { Nomenclature, NomenclatureTag, Tag } from '../domain';

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
    parent: parent || null,
    tag: child || buildFakeTag({}),
  };
};

export const buildFakeNomenclature = ({
  id,
  reference,
  tags = [],
}: Partial<Nomenclature>): Nomenclature => {
  return {
    id: id || 666,
    tags,
    reference: reference || 'dummy_ref',
  };
};
