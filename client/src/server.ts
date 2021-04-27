/* eslint-disable */
import sirv from 'sirv';
import polka from 'polka';

import compression from 'compression';
import * as sapper from '@sapper/server';
import { i18nMiddleware, addLocaleToRequest } from './modules/i18n';
import { communityMiddleWare } from './modules/community';
import cookieParser from 'cookie-parser';
import { authentificationMiddleWare } from './modules/authentification';
import { setBaseUrl } from './modules/axios';

const { PORT, NODE_ENV } = process.env;
const dev = NODE_ENV === 'development';

const apiUrlSsr = process.env.API_URL_SSR
  ? process.env.API_URL_SSR
  : process.env.API_URL;
console.info(`Use this url for SSR api calls: ${apiUrlSsr}`);
setBaseUrl(apiUrlSsr);

polka()
  .use(
    cookieParser(),
    compression({ threshold: 0 }),
    sirv('static', { dev }),
    addLocaleToRequest(),
    i18nMiddleware(),
    communityMiddleWare(),
    authentificationMiddleWare(),
    sapper.middleware({
      session: (req) => {
        return {
          locale: req.locale,
          communityId: req.communityId,
          userId: req.userId,
          isAuthenticated: !!req.userId,
          apiUrl: process.env.API_URL,
        };
      },
    })
  )
  .listen(PORT, (err: Error) => {
    if (err) console.error('error', err);
  });
