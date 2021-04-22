<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Error from './Error.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';
</script>

<Meta
  title="Vimeet365/Error"
  component={Error}
  argTypes={{
    highlight: { control: 'boolean' },
  }}
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
  <Error {...args} />
</Template>

<Story name="Normal" />
