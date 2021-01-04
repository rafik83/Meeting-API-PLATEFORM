/* eslint-disable */

import sirv from 'sirv';
import polka from 'polka';
import compression from 'compression';
import * as sapper from '@sapper/server';

const { PORT, NODE_ENV } = process.env;
const dev = NODE_ENV === 'development';

function detectLocale(req, res, next) {
  const locale = req.headers['x-force-locale'];
  if (locale) {
    req.locale = locale;
    req.baseUrl = '/' + locale;
  } else {
    req.locale = null;
  }
  next();
}

polka() // You can also use Express
  .use(
    detectLocale,
    compression({ threshold: 0 }),
    sirv('static', { dev }),
    sapper.middleware({
      session: (req, res) => {locale: req.locale}
    })
  )
  .listen(PORT, (err) => {
    if (err) console.log('error', err);
  });
