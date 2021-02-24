import TermsAndConditions from './TermsAndConditions.svelte';

export default {
  title: 'Vimeet365/TermsAndConditions',
  component: TermsAndConditions,
  args: {
    name: '',
  },
};

const Template = ({ ...args }) => ({
  Component: TermsAndConditions,
  props: args,
});

export const base = Template.bind({});
export const error = Template.bind({});

error.args = {
  ...base.args,
  errorMessage: 'Veuillez cliquer',
};
