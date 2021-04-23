import {
  init,
  locale as localeStore,
  register,
  getLocaleFromPathname,
  locales,
} from 'svelte-i18n';

import { currentLocale } from '../stores/localeStore';

register('en', () => import('../messages/en.json'));
register('fr', () => import('../messages/fr.json'));

const getSupportedLocales = (): Array<string> => {
  let supportedLocales: Array<string>;
  locales.subscribe((value) => {
    supportedLocales = value;
  });

  return supportedLocales;
};

const DOCUMENT_REGEX = /(^([^.?#@]+)?([?#](.+)?)?|service-worker.*?\.html)$/;

const getLocaleFromRequestURL = (route) => {
  const localeString = getSupportedLocales().join('|');
  const localeRegex = new RegExp(`/${localeString}(/|$)`, 'gm');
  const localesFromURL = route.match(localeRegex);

  if (!route.match(DOCUMENT_REGEX) || !localesFromURL) {
    return null;
  }
  return localesFromURL[0].replace(/\//g, '');
};

const fallbackLocale = 'en';

export const addLocaleToRequest = () => {
  let previousURLLocale = null;
  return (req, res, next) => {
    const localeFromRoute = getLocaleFromRequestURL(req.url);
    if (localeFromRoute) {
      previousURLLocale = localeFromRoute;
    }
    const locale = localeFromRoute || previousURLLocale || fallbackLocale;

    currentLocale.set(locale);
    req.locale = locale;

    next();
  };
};

const INIT_OPTIONS = {
  fallbackLocale,
  initialLocale: null,
  loadingDelay: 200,
  formats: {},
  warnOnMissingMessages: true,
};

export const initClientI18n = () => {
  init({
    ...INIT_OPTIONS,
    initialLocale: getLocaleFromPathname(/^\/([a-z]{2})\/?/),
    fallbackLocale,
  });
};

export const i18nMiddleware = () => {
  let previousLocale;
  init({
    ...INIT_OPTIONS,
  });
  return (req, res, next) => {
    const isDocument = DOCUMENT_REGEX.test(req.originalUrl);
    // get the initial locale only for a document request
    if (!isDocument) {
      next();
      return;
    }
    const requestLocale = req.locale;

    if (requestLocale && requestLocale !== previousLocale) {
      localeStore.set(requestLocale);
      previousLocale = requestLocale;
    }

    next();
  };
};
