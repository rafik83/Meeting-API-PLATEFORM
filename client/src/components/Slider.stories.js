import Slider from "./Slider.svelte";
import PreviewDecorator from "./PreviewDecorator.svelte";

export default {
  title: 'Vimeet365/Slider',
  component: Slider,
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
    }
  ]
};

const Template = ({ ...args }) => ({
  Component: Slider,
  props: args,
});

export const base = Template.bind({});
