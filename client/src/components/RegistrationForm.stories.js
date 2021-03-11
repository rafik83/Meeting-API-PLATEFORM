import RegistrationForm from './RegistrationForm.svelte';

export default {
  title: 'Vimeet365/RegistrationForm',
  component: RegistrationForm,
  args: {
    signInUrl: '#',
  },
  argTypes: { onSubmitForm: { action: 'clicked' } },
};

const Template = ({ ...args }) => ({
  Component: RegistrationForm,
  props: args,
});

export const Base = Template.bind({});
export const Errored = Template.bind({});

Errored.args = {
  ...Base.args,
  errorMessage: "Ceci est un vrai message d'erreur",
};
