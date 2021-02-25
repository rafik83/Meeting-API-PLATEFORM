import { filterCountriesByName } from './autocompletion';

describe('autocompletion', () => {
  describe('filterCountriesByName', () => {
    const countries = [
      { code: 'en', name: 'Royaume-uni' },
      { code: 'fr', name: 'France' },
      { code: 'ru', name: 'Russie' },
      { code: 'be', name: 'Belgique' },
      { code: 'mc', name: 'Monaco' },
      { code: 'mn', name: 'Mongolia' },
      { code: 'me', name: 'Montenegro' },
    ];
    it('should return an array who matched tree first letter for an input string', () => {
      const inputSearch = 'Roy';
      const filterCountries = [{ code: 'en', name: 'Royaume-uni' }];
      expect(filterCountriesByName(countries, inputSearch)).toStrictEqual(
        filterCountries
      );
    });

    it('should return an empty array if the search is not find', () => {
      const inputSearch = 'Fffe';
      const filterCountries = [];
      expect(filterCountriesByName(countries, inputSearch)).toStrictEqual(
        filterCountries
      );
    });

    it('should return a list of results', () => {
      const inputSearch = 'Mon';
      const filterCountries = [
        { code: 'mc', name: 'Monaco' },
        { code: 'mn', name: 'Mongolia' },
        { code: 'me', name: 'Montenegro' },
      ];
      expect(filterCountriesByName(countries, inputSearch)).toStrictEqual(
        filterCountries
      );
    });

    it('should return a list of results -- with ignore case', () => {
      const inputSearch = 'mOn';
      const filterCountries = [
        { code: 'mc', name: 'Monaco' },
        { code: 'mn', name: 'Mongolia' },
        { code: 'me', name: 'Montenegro' },
      ];
      expect(filterCountriesByName(countries, inputSearch)).toStrictEqual(
        filterCountries
      );
    });
  });
});
