import type { Nomenclature } from '../domain';
import {
  buildFakeNomenclatureTag,
  buildFakeTag,
  buildFakeJobPositionNomenclature,
} from '../__fixtures__/FakeTags';
import { getJobPositionsFromNomenclature } from './nomenclatures';

describe('Account Repository', () => {
  it('should return the id from the location header', () => {
    const jobPosition1 = buildFakeTag({
      name: 'job1',
    });

    const jobPosition2 = buildFakeTag({
      name: 'job2',
    });

    const jobPositionNomenclatureTag1 = buildFakeNomenclatureTag(jobPosition1);

    const jobPositionNomenclatureTag2 = buildFakeNomenclatureTag(jobPosition2);

    const nomenclature: Nomenclature = buildFakeJobPositionNomenclature({
      tags: [jobPositionNomenclatureTag1, jobPositionNomenclatureTag2],
    });

    const result = getJobPositionsFromNomenclature(nomenclature);
    expect(result).toStrictEqual([jobPosition1, jobPosition2]);
  });
});
