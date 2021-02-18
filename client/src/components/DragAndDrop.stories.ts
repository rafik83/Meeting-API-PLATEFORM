import DragAndDrop from './DragAndDrop.svelte';

export default {
  title: 'Vimeet365/DragAndDrop',
  component: DragAndDrop,
  args: {},
};

const Template = ({ ...args }) => ({
  Component: DragAndDrop,
  props: args,
});

export const Base = Template.bind({});
