import type { User } from '../domain';

export const buildFakeUser = ({
  email,
  firstName,
  lastName,
  acceptedTermsAndConditions,
  members = [],
}: Partial<User>): User => {
  return {
    email: email || 'toto@toto.com',
    firstName: firstName || 'Jane',
    lastName: lastName || 'Doe',
    acceptedTermsAndConditions: acceptedTermsAndConditions || Date.now(),
    members,
  };
};
