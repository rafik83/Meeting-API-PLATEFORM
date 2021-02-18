import CompanyForm from './CompanyForm.svelte';

export default {
  title: 'Vimeet365/CompanyForm',
  component: CompanyForm,
  args: {
    toto: 'super chaine de caractère',
  },
};

const Template = ({ ...args }) => ({
  Component: CompanyForm,
  props: args,
});

export const Base = Template.bind({});
