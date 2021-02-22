import DragAndDrop from './DragAndDrop.svelte';

export default {
  title: 'Vimeet365/DragAndDrop',
  excludeStories: /.*Data$/,
  component: DragAndDrop,
};

const Template = ({ ...args }) => ({
  Component: DragAndDrop,
  props: args,
  argTypes: {
    onPinTask: { action: 'onPinTask' },
    onArchiveTask: { action: 'onArchiveTask' },
  },
});

export const Default = Template.bind({});

Default.args = {
  name: 'input_file',
  accept: ['image/jpeg', 'image/png'],
  maxSize: 1048576,
};

export const Error = Template.bind({});

Error.args = {
  ...Default.args,
  errorMessage: "Ceci est un message d'erreur",
};

export const Success = Template.bind({});

Success.args = {
  ...Default.args,
  successMessage: 'Ceci est un message de succès',
};

export const Loading = Template.bind({});

Loading.args = {
  ...Default.args,
  loading: true,
};
