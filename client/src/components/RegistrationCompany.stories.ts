import RegistrationCompany from './RegistrationCompany.svelte';

export default {
  title: 'Vimeet365/RegistrationCompany',
  component: RegistrationCompany,
  args: {
    toto: 'super chaine de caractère',
  },
};

const Template = ({ ...args }) => ({
  Component: RegistrationCompany,
  props: args,
});

export const Base = Template.bind({});
