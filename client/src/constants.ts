type RegistrationSteps = {
  [key: string]: string;
};

export const registrationSteps: RegistrationSteps = {
  SIGN_UP: 'signUp',
  SIGN_IN: 'Sign in',
};

type Sizes = {
  SMALL: string;
  MEDIUM: string;
  LARGE: string;
};

export const sizes: Sizes = {
  SMALL: 'small',
  MEDIUM: 'medium',
  LARGE: 'large',
};

type CardKind = {
  member: string;
  company: string;
  event: string;
};

export const CARD_KIND: CardKind = {
  member: 'member',
  company: 'company',
  event: 'community_event',
};
