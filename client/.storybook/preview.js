import '../static/tailwind.css';
import { addDecorator } from '@storybook/svelte';
import I18nWrapper from './I18nWrapper.svelte';
import PreviewWrapper from './PreviewWrapper.svelte';

export const parameters = {
  actions: { argTypesRegex: '^on[A-Z].*' },
  layout: 'centered',
};

export const decorators = [
  (storyFn) => {
    const story = storyFn();
    return {
      Component: I18nWrapper,
      props: {
        child: story.Component,
        props: story.props,
      },
    };
  },
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
];
