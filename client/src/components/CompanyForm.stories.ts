import CompanyForm from './CompanyForm.svelte';

export default {
  title: 'Vimeet365/CompanyForm',
  component: CompanyForm,
  args: {
    max: 30,
    selectOptions: [
      { code: 'en', name: 'Royaume-uni' },
      { code: 'fr', name: 'France' },
      { code: 'ru', name: 'Russie' },
      { code: 'be', name: 'Belgique' },
      { code: 'mc', name: 'Monaco' },
      { code: 'mn', name: 'Mongolia' },
      { code: 'me', name: 'Montenegro' },
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
