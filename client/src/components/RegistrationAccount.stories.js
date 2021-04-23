import { buldFakeTimeZone } from '../__fixtures__/FakeTimeZone';
import { buildFakeUser } from '../__fixtures__/FakeUser';
import {
  buildFakeNomenclatureTag,
  buildFakeTag,
} from '../__fixtures__/FakeTags';
import RegistrationAccount from './RegistrationAccount.svelte';

const jobPosition1 = buildFakeTag('Minister');
const jobPosition2 = buildFakeTag('Priest');

export default {
  title: 'Vimeet365/RegistrationAccount',
  component: RegistrationAccount,
  args: {
    user: buildFakeUser({}),
    jobPositions: [
      buildFakeNomenclatureTag(jobPosition1),
      buildFakeNomenclatureTag(jobPosition2),
    ],
    languages: [
      {
        code: 'fr',
        name: 'Français',
      },
      {
        code: 'nl',
        name: 'Néerlandais',
      },
    ],
    countries: [
      {
        code: 'fr',
        name: 'France',
      },
      {
        code: 'nl',
        name: 'Pays-Bas',
      },
    ],
    timezones: [
      buldFakeTimeZone('Madrid (Europe)'),
      buldFakeTimeZone('Pologne (Antartic)'),
    ],
  },
};

const Template = ({ ...args }) => ({
  Component: RegistrationAccount,
  props: args,
});

export const Base = Template.bind({});
