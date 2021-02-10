import FormInput from './FormInput.svelte';

export default {
  title: 'Vimeet365/FormInput',
  component: FormInput,
  args: {
    name: 'input_name',
    type: 'text',
    label: 'first name',
    value: '',
  },
};

const Template = ({ ...args }) => ({
  Component: FormInput,
  props: args,
});

export const Text = Template.bind({});
export const Email = Template.bind({});
export const Password = Template.bind({});
export const Errored = Template.bind({});
export const WithPreffiledValue = Template.bind({});

Email.args = {
  ...Text.args,
  label: 'your email',
  type: 'email',
};

Password.args = {
  ...Text.args,
  type: 'password',
};

Errored.args = {
  ...Text.args,
  label: 'Last Name',
  type: 'tex',
  errorMessage: 'A real error',
};

WithPreffiledValue.args = {
  ...Text.args,
  value: 'nice value',
};
