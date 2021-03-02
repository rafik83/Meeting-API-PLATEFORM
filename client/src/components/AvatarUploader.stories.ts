import AvatarUploader from './AvatarUploader.svelte';
import { buildFakeUser } from '../__fixtures__/FakeUser';

export default {
  title: 'Vimeet365/AvatarUploader',
  component: AvatarUploader,
};

const Template = ({ ...args }) => ({
  Component: AvatarUploader,
  props: args,
});

export const Default = Template.bind({});

Default.args = {
  dragAndDropName: 'Avatar Upload',
  name: 'input_file',
  accept: ['image/jpeg', 'image/png'],
  fileMaxSize: 1 * 1024 * 1024,
  user: buildFakeUser({}),
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
