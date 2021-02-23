import Button from './Button.svelte';

export default {
  title: 'Vimeet365/Button',
  component: Button,
  args: {
    content: "Envoyer",
    type: "submit"
  },
};

const Template = ({ ...args }) => ({
  Component: Button,
  props: args,
});

export const Submit = Template.bind({});
