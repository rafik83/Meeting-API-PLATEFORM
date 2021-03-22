import type { TimeZone } from '../domain';

export const buldFakeTimeZone = (
  name?: string,
  code?: string
): Partial<TimeZone> => {
  return {
    name: name || 'Paris/Bruxelles',
    code: code || 'fr-be',
  };
};
