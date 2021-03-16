import type { NomenclatureTag, QualificationStep } from '../domain';
import { buildFakeNomenclatureTag } from './FakeTags';

export const buildFakeQualificationStep = ({
  minTagCount,
  maxTagCount,
  position,
  nomenclatureTags,
  title,
  description,
  id,
}: {
  nomenclatureTags?: Array<NomenclatureTag>;
  minTagCount?: number;
  maxTagCount?: number;
  position?: number;
  description?: string;
  title?: string;
  id?: number;
}): QualificationStep => {
  return {
    nomenclature: {
      reference: 'fakeNomenclatureName',
      tags:
        nomenclatureTags && nomenclatureTags.length > 0
          ? nomenclatureTags
          : [buildFakeNomenclatureTag()],
      id: 66,
    },
    position: position || 3,
    title: title || 'fakeTitle',
    id: id || 666,
    min: minTagCount || 33,
    max: maxTagCount || 44,
    description: description || '',
  };
};
