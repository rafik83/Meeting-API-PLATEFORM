/* eslint-disable */

import sirv from 'sirv';
import polka from 'polka';
import compression from 'compression';
import * as sapper from '@sapper/server';

import { i18nMiddleware } from './modules/i18n';

const { PORT, NODE_ENV } = process.env;
const dev = NODE_ENV === 'development';



polka() // You can also use Express
  .use(
    compression({ threshold: 0 }),
    sirv('static', { dev }),
    i18nMiddleware(),
    sapper.middleware({
      session: (req, res) => {locale: req.locale}
    })
  )
  .listen(PORT, (err: Error) => {
    if (err) console.log('error', err);
  });
