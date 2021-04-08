import MemberAvatar from './MemberAvatar.svelte';

export default {
  title: 'Vimeet365/MemberAvatar',
  component: MemberAvatar,
  args: {
    url:
      'https://vivrelibredotblog.files.wordpress.com/2018/01/le-fond-et-la-forme.png',
    isOnline: null,
  },
};

const Template = ({ ...args }) => ({
  Component: MemberAvatar,
  props: args,
});

export const Default = Template.bind({});

export const Online = Template.bind({});
Online.args = {
  ...Default.args,
  isOnline: true,
};
export const Offline = Template.bind({});
Offline.args = {
  ...Default.args,
  isOnline: false,
};
