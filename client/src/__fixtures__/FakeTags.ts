import type { Nomenclature, Tag } from '../domain';

export const buildFakeTag = ({
  name,
  priority,
  id,
  parent,
}: Partial<Tag>): Tag => {
  return {
    priority,
    name: name || 'fakeTag',
    id: id || 666,
    parent: parent || null,
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
