import type { Tag, Nomenclature } from '../domain';
import { get } from '../modules/axios';

export const getJobPositionsFromNomenclature = (
  nomenclaturesTags: Nomenclature
): Array<Tag> => {
  return nomenclaturesTags.tags.map((item) => {
    return item.tag;
  });
};

export const getAllJobPositions = async (): Promise<Array<Tag>> => {
  const data = (await get<Nomenclature>('/nomenclatures/job_position')).data;

  return getJobPositionsFromNomenclature(data);
};
