<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Video from './Video.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';
  import { buildFakeVideo } from '../__fixtures__/FakeVideo';
</script>

<Meta
  title="Vimeet365/Video"
  component={Video}
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
  <Video {...args} />
</Template>

<Story name="Basic" args={{ ...buildFakeVideo() }} />
