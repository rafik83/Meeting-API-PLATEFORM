import DragAndDrop from './DragAndDrop.svelte';

export default {
  title: 'Vimeet365/DragAndDrop',
  component: DragAndDrop,
  args: {
    name: 'input_file',
    accept: '.jpg, .png',
    type: 'file',
    maxSize: 1048576,
  },
};

const Template = ({ ...args }) => ({
  Component: DragAndDrop,
  props: args,
});

export const InputFile = Template.bind({});
