import { register, init, locale as $locale } from 'svelte-i18n';

const INIT_OPTIONS = {
  fallbackLocale: 'fr',
  initialLocale: 'fr',
  loadingDelay: 200,
  formats: {},
  warnOnMissingMessages: true,
};

register('en', () => import('../messages/en.json'));
register('ar', () => import('../messages/ar.json'));
register('fr', () => import('../messages/fr.json'));

const getLocaleFromUrl = (url: string) => url.split('/')[1];

// initialize the i18n library in client
export function initClienti18n() {
  init({
    ...INIT_OPTIONS,
  });
}

$locale.subscribe((value) => {
  if (value === null) return;
});

// init only for routes (urls with no extensions such as .js, .css, etc) and for service worker
const DOCUMENT_REGEX = /(^([^.?#@]+)?([?#](.+)?)?|service-worker.*?\.html)$/;
// initialize the i18n library in the server and returns its middleware
export function i18nMiddleware() {
  // initialLocale will be set by the middleware
  init(INIT_OPTIONS);

  return (req, res, next) => {
    const isDocument = DOCUMENT_REGEX.test(req.originalUrl);
    // get the initial locale only for a document request
    if (!isDocument || req.url.startsWith('/service-worker')) {
      next();
      return;
    }
    let locale;

    const localeFromUrl = getLocaleFromUrl(req.url);
    if (!localeFromUrl) {
      locale = INIT_OPTIONS.initialLocale || INIT_OPTIONS.fallbackLocale;
    } else {
      locale = localeFromUrl;
    }
    req.locale = locale;
    next();
  };
}
