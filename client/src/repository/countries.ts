import type { Country } from '../domain';
import { get } from '../modules/axios';

export const getCountries = async (): Promise<Array<Country>> =>
  (await get<Array<Country>>('/countries')).data;
