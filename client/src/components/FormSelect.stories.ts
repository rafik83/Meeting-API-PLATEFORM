import FormSelect from './FormSelect.svelte';

export default {
  title: 'Vimeet365/FormSelect',
  component: FormSelect,
  args: {
  options: [
    { id: 'en', name: 'Royaume-uni' },
    { id: 'fr', name: 'France' },
    { id: 'ru', name: 'Russie' },
    { id: 'be', name: 'Belgique' },
    { id: 'mc', name: 'Monaco' },
    { id: 'mn', name: 'Mongolia' },
    { id: 'me', name: 'Montenegro' },
  ],
  name: "countries",
  label: "Pays",
  id: "coutries",
  },
};

const Template = ({ ...args }) => ({
  Component: FormSelect,
  props: args,
});

export const countries = Template.bind({});
