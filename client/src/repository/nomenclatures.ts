import type { Tag, Nomenclature } from '../domain';
import { get } from '../modules/axios';
import { getTagsFromNomenclature } from '../modules/tagManagement';

export const getAllJobPositions = async (): Promise<Array<Tag>> => {
  const data = (await get<Nomenclature>('/nomenclatures/job_position')).data;

  return getTagsFromNomenclature(data);
};
