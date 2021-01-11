/* eslint-disable */

import sirv from 'sirv';
import polka from 'polka';
import compression from 'compression';
import * as sapper from '@sapper/server';
import { i18nMiddleware } from './modules/i18n';
import { redirectToLocalePage } from './middlewares/redirect';

const { PORT, NODE_ENV } = process.env;
const dev = NODE_ENV === 'development';

polka()
  .use(
    compression({ threshold: 0 }),
    sirv('static', { dev }),
    i18nMiddleware(),
    redirectToLocalePage(),
    sapper.middleware({
      session: (req) => {
        return { locale: req.locale };
      },
    })
  )
  .listen(PORT, (err: Error) => {
    if (err) console.log('error', err);
  });
