import { filterCountriesByName } from './autocompletion';

describe('autocompletion', () => {
  describe('filterCountriesByName', () => {
    const countries = [
      { id: 'en', name: 'Royaume-uni' },
      { id: 'fr', name: 'France' },
      { id: 'ru', name: 'Russie' },
      { id: 'be', name: 'Belgique' },
      { id: 'mc', name: 'Monaco' },
      { id: 'mn', name: 'Mongolia' },
      { id: 'me', name: 'Montenegro' },
    ];
    it('should return an array who matched tree first letter for an input string', () => {
      const inputSearch = 'Roy';

      const filterCountries = [{ id: 'en', name: 'Royaume-uni' }];

      expect(filterCountriesByName(countries, inputSearch)).toStrictEqual(
        filterCountries
      );
    });

    it('should return undefined if less of 3 characters are input', () => {
      const inputSearch = 'Ro';

      const filterCountries = undefined;

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
        { id: 'mc', name: 'Monaco' },
        { id: 'mn', name: 'Mongolia' },
        { id: 'me', name: 'Montenegro' },
      ];
      expect(filterCountriesByName(countries, inputSearch)).toStrictEqual(
        filterCountries
      );
    }); 
    
    it('should return a list of results -- with ignore case', () => {
      const inputSearch = 'mOn';

      const filterCountries = [
        { id: 'mc', name: 'Monaco' },
        { id: 'mn', name: 'Mongolia' },
        { id: 'me', name: 'Montenegro' },
      ];
      expect(filterCountriesByName(countries, inputSearch)).toStrictEqual(
        filterCountries
      );
    });
  });
});
