import TagButton from './TagButton.svelte';
import PreviewWrapper from './PreviewWrapper.svelte';

const defaultProps = {
  name: 'myTag',
  priority: null,
  id: 666,
  displayPriority: true,
};

export default {
  title: 'Vimeet365/TagButton',
  component: TagButton,
  args: defaultProps,
  decorators: [
    (storyFn) => {
      const story = storyFn();

      return {
        Component: PreviewWrapper,
        props: {
          child: story.Component,
          props: story.props,
        },
      };
    },
  ],
};

const Template = ({ ...args }) => ({
  Component: Tag,
  props: args,
});

export const base = Template.bind({});

export const selected = Template.bind({});

selected.args = {
  ...base.args,
  priority: 10,
};

export const selectedWithNoPriority = Template.bind({});

selectedWithNoPriority.args = {
  ...base.args,
  displayPriority: false,
  priority: 10,
};
