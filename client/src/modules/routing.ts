let currentLocale: string;

import { locale as localeStore } from 'svelte-i18n';

localeStore.subscribe((value) => {
  currentLocale = value;
});

export const toCompanyPage = (id: number) => {
  return `${currentLocale}/company/${id}`;
};

export const toVideoConference = (roomId: number) => {
  return `${currentLocale}/videoconference/${roomId}`;
};

export const toMemberPage = (id: number) => {
  return `${currentLocale}/member/${id}`;
};

export const toOnboardingStep = (step: string, tagId?: number) => {
  if (!tagId) {
    return `${currentLocale}/onboarding/${step}`;
  }
  return `${currentLocale}/onboarding/${step}?tagId=${tagId}`;
};

export const toRegistrationStep = (step: string) => {
  return `${currentLocale}?target=${step}`;
};

export const toHomePage = () => {
  return `${currentLocale}`;
};
