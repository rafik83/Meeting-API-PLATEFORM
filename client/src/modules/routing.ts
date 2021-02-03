let currentLocale: string;

import { locale as localeStore } from 'svelte-i18n';

localeStore.subscribe((value) => {
  currentLocale = value;
});

export const toLoginPage = () => {
  return `${currentLocale}/join/login`;
};

export const toRegistrationPage = () => {
  return `${currentLocale}/registration`;
};

export const toRegistrationStep = (step: number) => {
  return `${currentLocale}/registration/step-${step}`;
};

export const toHomePage = () => {
  return `${currentLocale}`;
};
