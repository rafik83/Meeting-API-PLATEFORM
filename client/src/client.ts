import * as sapper from '@sapper/app';

import { initClienti18n } from './modules/i18n';

initClienti18n();

sapper.start({
  target: document.querySelector('#sapper'),
});
