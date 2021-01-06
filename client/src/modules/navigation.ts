import { goto as _goto } from '@sapper/app';
import { locale as localeStore } from 'svelte-i18n';

export const goTo = async (route: string, locale: string = null) => {
  if (locale) {
    localeStore.set(locale);
  }
  await _goto(route);
};

export const getUrl = (route: string) => {
  let locale: string;

  localeStore.subscribe((value) => {
    locale = value;
  });
  const URL = `${locale}/${route}`;
  return URL;
};
