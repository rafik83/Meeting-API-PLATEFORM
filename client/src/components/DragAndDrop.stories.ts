import DragAndDrop from './DragAndDrop.svelte';

export default {
  title: 'Vimeet365/DragAndDrop',
  excludeStories: /.*Data$/,
  component: DragAndDrop,
};

const Template = ({ ...args }) => ({
  Component: DragAndDrop,
  props: args,
  argTypes: {},
});

export const Default = Template.bind({});

Default.args = {
  name: 'input_file',
  accept: ['image/jpeg', 'image/png'],
  fileMaxSize: 1 * 1024 * 1024,
};

export const Errored = Template.bind({});

Errored.args = {
  ...Default.args,
  fileMaxSize: 15,
};

export const Success = Template.bind({});

Success.args = {
  ...Default.args,
};

export const Loading = Template.bind({});

Loading.args = {
  ...Default.args,
  loading: true,
};
