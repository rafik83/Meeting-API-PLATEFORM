<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import PreviewDecorator from './PreviewDecorator.svelte';
  import MediaCard from './MediaCard.svelte';
  import { buildFakeMediaCard } from '../__fixtures__/FakeCards';

  const defaultProps = {
    ...buildFakeMediaCard({
      video:
        'https://test-videos.co.uk/vids/bigbuckbunny/mp4/h264/720/Big_Buck_Bunny_720_10s_2MB.mp4',
      description:
        '<h3> My nice title </h3>\n\nLorem ipsum dolor sit amet, <b>consectetur adipiscing elit</b>. Praesent placerat turpis magna, ac imperdiet ipsum accumsan ut. Integer elementum facilisis tortor auctor dignissim. Duis ac fermentum mi, a suscipit tortor. ',
    }),
  };
</script>

<Meta
  title="Vimeet365/MediaCard"
  parameters={defaultProps}
  component={MediaCard}
/>

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
  <MediaCard {...args} />
</Template>

<Story name="Basic" args={{ ...defaultProps }} />
