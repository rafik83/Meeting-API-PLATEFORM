import * as sapper from '@sapper/app';

import { startClient } from './modules/i18n';

startClient();

sapper.start({
  target: document.querySelector('#sapper'),
});
