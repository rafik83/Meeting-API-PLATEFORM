import IconPreview from './IconPreview.svelte';
import PreviewDecorator from '../components/PreviewDecorator.svelte';

export default {
  title: 'Vimeet365/UIKit/Icons',
  component: IconPreview,
  decorators: [
    (storyFun) => {
      const story = storyFun();
      return {
        Component: PreviewDecorator,
        props: {
          child: story.Component,
          props: story.props,
        },
      };
    },
  ],
};

const Template = ({ ...args }) => ({
  Component: IconPreview,
  props: args,
});

export const Basic = Template.bind({});
