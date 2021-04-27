<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import PreviewDecorator from './PreviewDecorator.svelte';
  import FeaturingSlider from './FeaturingSlider.svelte';
  import { buildFakeFeaturingSlides } from '../__fixtures__/FakeFeaturingSlide';
</script>

<Meta title="Vimeet365/FeaturingSlider" component={FeaturingSlider} />

<Template
  let:args
  decorators={[
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
  ]}
>
  <FeaturingSlider {...args} slides={buildFakeFeaturingSlides()} />
</Template>

<Story name="Basic" />
