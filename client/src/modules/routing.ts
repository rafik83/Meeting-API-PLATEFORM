let currentLocale: string;

import { locale as localeStore } from 'svelte-i18n';

localeStore.subscribe((value) => {
  currentLocale = value;
});

export const toOnboardingStep = (step: number) => {
  return `${currentLocale}/onboarding/${step}`;
};

export const toRegistrationStep = (step: string) => {
  return `${currentLocale}?target=${step}`;
};

export const toHomePage = () => {
  return `${currentLocale}`;
};
