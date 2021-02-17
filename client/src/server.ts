/* eslint-disable */
import sirv from 'sirv';
import polka from 'polka';

import compression from 'compression';
import * as sapper from '@sapper/server';
import { i18nMiddleware, addLocaleToRequest } from './modules/i18n';
import { communityMiddleWare } from './modules/community';

const { PORT, NODE_ENV } = process.env;
const dev = NODE_ENV === 'development';

polka()
  .use(
    compression({ threshold: 0 }),
    sirv('static', { dev }),
    addLocaleToRequest(),
    i18nMiddleware(),
    communityMiddleWare(),
    sapper.middleware({
      session: (req) => {
        return { locale: req.locale, communityId: req.communityId };
      },
    })
  )
  .listen(PORT, (err: Error) => {
    if (err) console.log('error', err);
  });
