<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import {
    buildFakeCompanyCard,
    buildFakeEventCard,
    buildFakeMemberCard,
    buildFakeMediaCard,
  } from '../__fixtures__/FakeCards';
  import PreviewDecorator from './PreviewDecorator.svelte';
  import CardSlider from './CardSlider.svelte';

  const defaultProps = {
    cards: [
      buildFakeEventCard(),
      buildFakeMediaCard({
        video:
          'https://test-videos.co.uk/vids/bigbuckbunny/mp4/h264/720/Big_Buck_Bunny_720_10s_2MB.mp4',
        description:
          '<h3> My nice title </h3>\n\nLorem ipsum dolor sit amet, <b>consectetur adipiscing elit</b>. Praesent placerat turpis magna, ac imperdiet ipsum accumsan ut. Integer elementum facilisis tortor auctor dignissim. Duis ac fermentum mi, a suscipit tortor. ',
      }),
      buildFakeMemberCard(),
      buildFakeEventCard(),
      buildFakeMemberCard(),
      buildFakeCompanyCard(),
      buildFakeMemberCard(),
      buildFakeMemberCard(),
    ],
    title: 'Title of list',
  };
</script>

<Meta
  title="Vimeet365/CardSlider"
  component={CardSlider}
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
  <CardSlider {...args} />
</Template>

<Story name="Normal" args={{ ...defaultProps }} />
