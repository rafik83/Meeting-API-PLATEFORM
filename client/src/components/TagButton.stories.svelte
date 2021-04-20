<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import TagButton from './TagButton.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';

  export const defaultProps = {
    name: 'myTag',
    priority: null,
    id: 666,
    displayPriority: true,
    sticky: false,
  };
</script>

<Meta
  title="Vimeet365/TagButton"
  component={TagButton}
  argTypes={{
    highlight: { control: 'boolean' },
  }}
  parameters={defaultProps}
  decorators={[
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
  ]}
/>

<Template let:args>
  <TagButton {...args} />
</Template>

<Story
  name="WithPrioritySticky"
  args={{
    ...defaultProps,
    displayPriority: true,
    priority: 22,
    sticky: true,
  }}
/>

<Story
  name="WithoutPriorirty"
  args={{
    ...defaultProps,
  }}
/>

<Story
  name="WithPriorityNotSticky"
  args={{
    ...defaultProps,
    displayPriority: true,
    priority: 88,
  }}
/>
