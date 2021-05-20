export const getDomainFromEmail = (email: string): string => {
  return email.split('@')[1];
};
