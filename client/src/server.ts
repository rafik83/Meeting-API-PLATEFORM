/* eslint-disable no-undef */
import polka, { ListenCallback } from 'polka';
import sirv from 'sirv';

import compression from 'compression';
import * as sapper from '@sapper/server';
import type { MiddlewareOptions, SapperRequest } from '@sapper/server';
import { addLocaleToRequest, i18nMiddleware } from './modules/i18n';
import { communityMiddleWare } from './modules/community';
import { authentificationMiddleWare } from './modules/authentification';
import cookieParser from 'cookie-parser';
import { setBaseUrl } from './modules/axios';

const apiUrlSsr = process.env.API_URL_SSR
  ? process.env.API_URL_SSR
  : process.env.API_URL;
console.info(`Use this url for SSR api calls: ${apiUrlSsr}`);
setBaseUrl(apiUrlSsr);

const { PORT, NODE_ENV } = process.env;
const dev = NODE_ENV === 'development';

const buildSapperMiddleWareOptions = (): MiddlewareOptions => {
  return {
    session: (req: SapperRequest) => ({
      locale: req.locale,
      communityId: req.communityId,
      userId: req.userId,
      isAuthenticated: !!req.userId,
      // eslint-disable-next-line no-undef
      apiUrl: process.env.API_URL,
    }),
  };
};

const callBack: ListenCallback = () => {};

const app = polka();

app.use(
  //@ts-ignore
  cookieParser(),
  addLocaleToRequest(),
  i18nMiddleware(),
  communityMiddleWare(),
  authentificationMiddleWare()
);

app.use(
  //@ts-ignore
  compression({ threshold: 0 }),
  sirv('static', { dev }),
  sapper.middleware(buildSapperMiddleWareOptions())
);

app.listen(PORT, callBack);
