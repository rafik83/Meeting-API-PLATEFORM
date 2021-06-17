import { init, locale } from 'svelte-i18n';
import { formatEventCardDate } from './date';

beforeEach(() => {
  init({ fallbackLocale: undefined });
  locale.set(undefined);
});

describe('date', () => {
  describe('formatEventCardDate', () => {
    it('should retrun date of one dayin american format', () => {
      init({ fallbackLocale: 'en' });

      const startDate = '2021-06-11T12:38:39.755Z';
      const endDate = '2021-06-11T12:38:39.755Z';
      const result = 'June 11<sup>th</sup> 2021';

      expect(formatEventCardDate(startDate, endDate)).toStrictEqual(result);
    });

    it('should retrun date of one dayin american format -- with "st" ordinal', () => {
      init({ fallbackLocale: 'en' });

      const startDate = '2021-06-01T12:38:39.755Z';
      const endDate = '2021-06-01T12:38:39.755Z';
      const result = 'June 1<sup>st</sup> 2021';

      expect(formatEventCardDate(startDate, endDate)).toStrictEqual(result);
    });

    it('should retrun date of one day in american format -- with "nd" ordinal', () => {
      init({ fallbackLocale: 'en' });

      const startDate = '2021-06-02T12:38:39.755Z';
      const endDate = '2021-06-02T12:38:39.755Z';
      const result = 'June 2<sup>nd</sup> 2021';

      expect(formatEventCardDate(startDate, endDate)).toStrictEqual(result);
    });

    it('should retrun date of one day in american format -- with "rd" ordinal', () => {
      init({ fallbackLocale: 'en' });

      const startDate = '2021-06-03T12:38:39.755Z';
      const endDate = '2021-06-03T12:38:39.755Z';
      const result = 'June 3<sup>rd</sup> 2021';

      expect(formatEventCardDate(startDate, endDate)).toStrictEqual(result);
    });

    it('should retrun a french date of one day', () => {
      init({ fallbackLocale: 'fr' });

      const startDate = '2021-06-11T12:38:39.755Z';
      const endDate = '2021-06-11T12:38:39.755Z';
      const result = '11 juin 2021';

      expect(formatEventCardDate(startDate, endDate)).toStrictEqual(result);
    });

    it('should return a date with two days difference in American format', () => {
      init({ fallbackLocale: 'en' });

      const startDate = '2021-06-11T12:38:39.755Z';
      const endDate = '2021-06-13T12:38:39.755Z';
      const result = 'June 11<sup>th</sup> > 13<sup>th</sup> 2021';

      expect(formatEventCardDate(startDate, endDate)).toStrictEqual(result);
    });

    it('should retrun a french date with two different days', () => {
      init({ fallbackLocale: 'fr' });

      const startDate = '2021-06-11T12:38:39.755Z';
      const endDate = '2021-06-13T12:38:39.755Z';
      const result = '11 > 13 juin 2021';

      expect(formatEventCardDate(startDate, endDate)).toStrictEqual(result);
    });

    it('should return a date with two months difference in American format', () => {
      init({ fallbackLocale: 'en' });

      const startDate = '2021-06-11T12:38:39.755Z';
      const endDate = '2021-07-11T12:38:39.755Z';
      const result = 'June 11<sup>th</sup> > July 11<sup>th</sup> 2021';

      expect(formatEventCardDate(startDate, endDate)).toStrictEqual(result);
    });

    it('should retrun a french date with two different months', () => {
      init({ fallbackLocale: 'fr' });

      const startDate = '2021-06-11T12:38:39.755Z';
      const endDate = '2021-07-11T12:38:39.755Z';
      const result = '11 juin > 11 juillet 2021';

      expect(formatEventCardDate(startDate, endDate)).toStrictEqual(result);
    });
  });
});
