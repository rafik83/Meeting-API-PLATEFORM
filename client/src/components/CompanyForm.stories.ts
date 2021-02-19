import CompanyForm from './CompanyForm.svelte';

export default {
  title: 'Vimeet365/CompanyForm',
  component: CompanyForm,
  args: {
    max: 30,
    options: [
      { id: 'en', name: 'Royaume-uni' },
      { id: 'fr', name: 'France' },
    ],
    errors: {},
  },
};

const Template = ({ ...args }) => ({
  Component: CompanyForm,
  props: args,
});

export const Base = Template.bind({});
export const Errors = Template.bind({});

Errors.args = {
  ...Base.args,
  errors: {
    compagnyName: "It's your compagny seriously ?!",
    selectedLocale: 'Not this country... please...',
    compagnyWebsite: 'Dafuck is this url?',
    compagnyDescription: "Dude! it's too much...",
  },
};
