import CardSlider from './CardSlider.svelte';
import PreviewDecorator from './PreviewDecorator.svelte';
import { buildFakeMemberCards } from '../__fixtures__/FakeMemberCard';

export default {
  title: 'Vimeet365/CardSlider',
  component: CardSlider,
  args: {
    memberDataForCards: buildFakeMemberCards(),
    title: "Title of list"
  },
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
  Component: CardSlider,
  props: args,
});

export const basic = Template.bind({});
