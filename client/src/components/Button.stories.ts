import Button from './Button.svelte';

export default {
  title: 'Vimeet365/Button',
  component: Button,
  args: {
    type: 'submit',
    kind: 'primary'
  },
};

const Template = ({ ...args }) => ({
  Component: Button,
  props: args,
});

export const primary = Template.bind({});
export const secondary = Template.bind({});
export const tiertiary = Template.bind({});
export const community = Template.bind({});
export const ghost = Template.bind({});
export const outlined = Template.bind({});

secondary.args = {
  ...primary.args,
  kind: 'secondary',
};

tiertiary.args = {
  ...primary.args,
  kind: 'tiertiary',
};

community.args = {
  ...primary.args,
  kind: 'community'
};

ghost.args = {
  ...primary.args,
  kind: 'ghost',
};

outlined.args = {
  ...primary.args,
  kind: 'outlined',
};
