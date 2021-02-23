import CompanyForm from './CompanyForm.svelte';

export default {
  title: 'Vimeet365/CompanyForm',
  component: CompanyForm,
  args: {
    max: 30,
    options: [
      { id: 'en', name: 'Royaume-uni' },
      { id: 'fr', name: 'France' },
      { id: 'ru', name: 'Russie' },
      { id: 'be', name: 'Belgique' },
      { id: 'mc', name: 'Monaco' },
      { id: 'mn', name: 'Mongolia' },
      { id: 'me', name: 'Montenegro' },
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
    compagnyName: 'fe',
    selectedLocale: 'fe',
    compagnyWebsite: 'fe',
    compagnyDescription: 'fe',
  },
};
