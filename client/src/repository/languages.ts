import type { Language } from '../domain';
import { get } from '../modules/axios';

export const getLanguages = async (): Promise<Array<Language>> => {
  return (await get<Array<Language>>('languages')).data;
};
