let currentLocale: string;

import { locale as localeStore } from 'svelte-i18n';

localeStore.subscribe((value) => {
  currentLocale = value;
});

export const toRegistrationStep = (step: string) => {
  return `${currentLocale}?step=${step}`;
};

export const toHomePage = () => {
  return `${currentLocale}`;
};
