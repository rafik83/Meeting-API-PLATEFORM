<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import PicturePlaceholder from './PicturePlaceholder.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';
</script>

<Meta
  title="Vimeet365/PicturePlaceholder"
  component={PicturePlaceholder}
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
  <PicturePlaceholder {...args} />
</Template>

<Story name="Basic" />

<Story
  name="With Text Content"
  args={{
    textContent: 'A nice text',
  }}
/>
