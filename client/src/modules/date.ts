import { getDateFormatter, locale } from 'svelte-i18n';
import type { DateObject } from '../domain';

export const formatEventCardDate = (
  startDate: string,
  endDate: string
): string => {
  const begin = createDateObject(new Date(startDate));
  const end = createDateObject(new Date(endDate));
  const locale = getCurrentLocale();

  if (locale.match('en')) {
    begin.day += `<sup>${getOrdinalOfThe(parseInt(begin.day, 10))}</sup>`;
    end.day += `<sup>${getOrdinalOfThe(parseInt(end.day, 10))}</sup>`;
  }

  if (begin.day === end.day && begin.month === end.month) {
    if (locale.match('fr')) {
      return `${begin.day} ${begin.month} ${begin.year}`;
    }
    return `${begin.month} ${begin.day} ${begin.year}`;
  }

  if (begin.month === end.month) {
    if (locale.match('fr')) {
      return `${begin.day} > ${end.day} ${end.month} ${end.year}`;
    }
    return `${begin.month} ${begin.day} > ${end.day} ${end.year}`;
  }

  if (locale.match('fr')) {
    return `${begin.day} ${begin.month} > ${end.day} ${end.month} ${end.year}`;
  }
  return `${begin.month} ${begin.day} > ${end.month} ${end.day} ${end.year}`;
};

const getCurrentLocale = (): string => {
  let currentLocale: string = '';
  locale.subscribe((loc) => (currentLocale = loc));
  return currentLocale;
};

const createDateObject = (date: Date): DateObject => {
  return <DateObject>getDateFormatter({ format: 'long' })
    .formatToParts(date)
    .filter(({ type }) => type !== 'literal')
    .reduce((acc, { type, value }) => {
      acc[type] = value;
      return acc;
    }, {});
};

const getOrdinalOfThe = (day: number): string => {
  if (day > 3 && day < 21) {
    return 'th';
  }
  switch (day % 10) {
    case 1:
      return 'st';
    case 2:
      return 'nd';
    case 3:
      return 'rd';
    default:
      return 'th';
  }
};
