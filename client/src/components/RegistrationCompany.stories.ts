import { buildFakeUser } from '../__fixtures__/FakeUser';
import RegistrationCompany from './RegistrationCompany.svelte';

export default {
  title: 'Vimeet365/RegistrationCompany',
  component: RegistrationCompany,
  args: {
    user: buildFakeUser({}),
    countryList: [
      { code: 'en', name: 'Royaume-uni' },
      { code: 'fr', name: 'France' },
      { code: 'ru', name: 'Russie' },
      { code: 'be', name: 'Belgique' },
      { code: 'mc', name: 'Monaco' },
      { code: 'mn', name: 'Mongolia' },
      { code: 'me', name: 'Montenegro' },
    ],
  },
};

const Template = ({ ...args }) => ({
  Component: RegistrationCompany,
  props: args,
});

export const Base = Template.bind({});
