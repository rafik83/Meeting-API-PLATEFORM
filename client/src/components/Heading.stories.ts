import Heading from './Heading.svelte';

export default {
  title: 'Vimeet365/Headings',
  component: Heading,
  args: {
    type: 'h1',
    content: 'Je suis un h1',
  },
};

const Template = ({ ...args }) => ({
  Component: Heading,
  props: args,
});

export const H1 = Template.bind({});
export const H2 = Template.bind({});

H2.args = {
  ...H1.args,
  type: 'h2',
  content: 'je suis un h2',
};
