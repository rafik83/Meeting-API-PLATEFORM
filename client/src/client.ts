import * as sapper from '@sapper/app';

import { initClientI18n } from './modules/i18n';

initClientI18n();

sapper.start({
  target: document.querySelector('#sapper'),
});
