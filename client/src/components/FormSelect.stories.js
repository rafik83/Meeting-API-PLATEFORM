import FormSelect from './FormSelect.svelte';
import PreviewDecorator from './PreviewDecorator.svelte';

export default {
  title: 'Vimeet365/FormSelect',
  component: FormSelect,
  args: {
    options: [
      { code: 'en', name: 'Royaume-uni' },
      { code: 'fr', name: 'France' },
      { code: 'ru', name: 'Russie' },
      { code: 'be', name: 'Belgique' },
      { code: 'mc', name: 'Monaco' },
      { code: 'mn', name: 'Mongolia' },
      { code: 'me', name: 'Montenegro' },
    ],
    name: 'countries',
    label: 'Pays',
    id: 'coutries',
  },
  decorators: [
    (storyFn) => {
      const story = storyFn();

      return {
        Component: PreviewDecorator,
        props: {
          child: story.Component,
          props: story.props,
        },
      };
    },
  ],
};

const Template = ({ ...args }) => ({
  Component: FormSelect,
  props: args,
});

export const Basic = Template.bind({});
export const SearchBar = Template.bind({});

SearchBar.args = {
  ...Basic.args,
  searchBar: true,
};
