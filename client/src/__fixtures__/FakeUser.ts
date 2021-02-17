import type { User } from '../domain';

export const buildFakeUser = ({
  email,
  firstName,
  lastName,
  acceptedTermsAndConditions,
}: Partial<User>): User => {
  return {
    email: email || 'toto@toto.com',
    firstName: firstName || 'Jane',
    lastName: lastName || 'Doe',
    acceptedTermsAndConditions: acceptedTermsAndConditions || Date.now(),
  };
};
