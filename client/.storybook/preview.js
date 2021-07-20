import { addDecorator } from '@storybook/svelte';
import I18nWrapper from './I18nWrapper.svelte';
import './storybook.css';

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
];
