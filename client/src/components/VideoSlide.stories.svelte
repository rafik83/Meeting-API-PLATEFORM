<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import VideoSlide from './VideoSlide.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';
  import { buildFakeFeaturingSlide } from '../__fixtures__/FakeFeaturingSlide';
</script>

<Meta
  title="Vimeet365/VideoSlide"
  component={VideoSlide}
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
  <VideoSlide {...args} />
</Template>

<Story name="Basic" args={{ ...buildFakeFeaturingSlide() }} />
