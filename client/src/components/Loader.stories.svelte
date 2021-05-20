<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Loader from './Loader.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';
</script>

<Meta
  title="Vimeet365/Loader"
  component={Loader}
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
  <Loader {...args} />
</Template>

<Story name="Normal" />
