import { goto as _goto } from '@sapper/app';
import { locale as localeStore } from 'svelte-i18n';

const goTo = async (route: string, locale: string = null) => {
  if (locale) {
    localeStore.set(locale);
  }
  await _goto(route);
};

export default goTo;
