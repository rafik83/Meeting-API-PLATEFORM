import IconPreview from './IconPreview.svelte';

export default {
  title: 'Vimeet365/IconPreview',
  component: IconPreview,
};

const Template = ({ ...args }) => ({
  Component: IconPreview,
  props: args,
});

export const Basic = Template.bind({});
