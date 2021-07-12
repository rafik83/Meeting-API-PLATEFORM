import type { MediaType } from './domain';

type RegistrationSteps = {
  // eslint-disable-next-line no-unused-vars
  [key in 'SIGN_UP' | 'SIGN_IN']: string;
};

export const registrationSteps: RegistrationSteps = {
  SIGN_UP: 'signUp',
  SIGN_IN: 'Sign in',
};

type Sizes = {
  // eslint-disable-next-line no-unused-vars
  [key in 'SMALL' | 'MEDIUM' | 'LARGE']: string;
};

export const sizes: Sizes = {
  SMALL: 'small',
  MEDIUM: 'medium',
  LARGE: 'large',
};

type CardKind = {
  // eslint-disable-next-line no-unused-vars
  [key in 'MEMBER' | 'COMPANY' | 'EVENT' | 'MEDIA']: string;
};

export const CARD_KIND: CardKind = {
  MEMBER: 'member',
  COMPANY: 'company',
  EVENT: 'community_event',
  MEDIA: 'media',
};

type CardMediaTypes = {
  // eslint-disable-next-line no-unused-vars
  [key in 'PRESS' | 'REPLAY']: MediaType;
};

export const CARD_MEDIA_TYPE: CardMediaTypes = {
  PRESS: 'press',
  REPLAY: 'replay',
};
