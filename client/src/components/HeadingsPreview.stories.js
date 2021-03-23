import HeadingsPreview from './HeadingsPreview.svelte';

export default {
  title: 'Vimeet365/UIKit/Headings',
  component: HeadingsPreview,
};

const Template = ({ ...args }) => ({
  Component: HeadingsPreview,
  props: args,
});

export const Basic = Template.bind({});

export const Community = Template.bind({});
Community.args = {
  community: true,
};
