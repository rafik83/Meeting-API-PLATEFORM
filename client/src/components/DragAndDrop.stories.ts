import DragAndDrop from './DragAndDrop.svelte';
import type { ErrorReport } from '../modules/fileManagement';

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
  maxSize: 1*1024*1024,
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

export const WithValidationErrors = Template.bind({});

const fakeErrorReport: ErrorReport = {
  fileName: 'hello.jpeg',
  hasErrors: true,
  errors: {
    maxSizeExceeded: true,
  },
};

WithValidationErrors.args = {
  ...Default.args,
  validateFiles: () => [fakeErrorReport],
};

export const WithoutValidationErrors = Template.bind({});

const errorReport2: ErrorReport = {
  fileName: 'hello.jpeg',
  hasErrors: false,
  errors: {
    maxSizeExceeded: true,
  },
};

WithoutValidationErrors.args = {
  ...Default.args,
  validateFiles: () => [errorReport2],
};
