import type { Company } from '../domain';

export const buildFakeCompany = ({
  id,
  name,
  logo,
  countryCode,
  activity,
  website,
}: Partial<Company>): Company => {
  return {
    id: id || 666,
    name: name || 'Evil corp',
    logo: logo || 'https://www.fillmurray.com/100/100',
    countryCode: countryCode || 'FR',
    activity: activity || 'Save the world',
    website: website || 'https://evilcorp.com',
  };
};
