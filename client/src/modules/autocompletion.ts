import type { Country } from '../domain';

export const filterCountriesByName = (
  datas: Array<Country>,
  search: String
): Array<Country> => {
  return datas.filter((data) => data.name.match(new RegExp('^' + search, 'i')));
};
