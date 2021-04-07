import Tag from './Tag.svelte';

export default {
  title: 'Vimeet365/Tag',
  component: Tag,
  args: {
    kind: 'normal',
  },
};

const Template = ({ ...args }) => ({
  Component: Tag,
  props: args,
});

export const normal = Template.bind({});
export const goal = Template.bind({});

goal.args = {
  ...normal.args,
  kind: 'goal',
};
