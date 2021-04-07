import { buildFakeTag } from '../__fixtures__/FakeTags';
import TagSelector from './TagSelector.svelte';
import PreviewDecorator from './PreviewDecorator.svelte';

const fakeTag1 = buildFakeTag({ name: 'un tag', id: 1, priority: null });
const fakeTag2 = buildFakeTag({
  name: 'un tag plus long',
  id: 2,
  priority: null,
});
const fakeTag3 = buildFakeTag({
  name: 'un autre tag avec un texte plus long',
  id: 3,
  priority: null,
});
const fakeTag4 = buildFakeTag({
  name:
    'un autre tag avec un texte plus long car il faut bien tester les edge cases',
  id: 4,
  priority: null,
});

const defaultProps = {
  min: null,
  max: null,
  title: 'a very nice title',
  tags: [fakeTag1, fakeTag2, fakeTag3, fakeTag4],
};

export default {
  title: 'Vimeet365/TagSelector',
  component: TagSelector,
  args: defaultProps,
  argTypes: { onNext: { action: 'clicked' } },

  decorators: [
    (storyFn) => {
      const story = storyFn();

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
  Component: TagSelector,
  props: args,
});

export const base = Template.bind({});

export const withoutTitle = Template.bind({});

withoutTitle.args = {
  ...base.args,
  min: 1,
  title: null,
  description: 'A nice description',
  tags: [fakeTag4, fakeTag1, fakeTag2, fakeTag3],
};

export const withAMaximumOfTagExpected = Template.bind({});

withAMaximumOfTagExpected.args = {
  ...base.args,
  min: 1,
  max: 2,
  title: null,
  description: 'A nice description',
  tags: [fakeTag4, fakeTag1, fakeTag2, fakeTag3],
};

export const Errored = Template.bind({});

Errored.args = {
  ...base.args,
  errorMessage: 'Oupsy an error',
};
