<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import {
    buildFakeCompanyCard,
    buildFakeEventCard,
    buildFakeMemberCard,
  } from '../__fixtures__/FakeCards';
  import PreviewDecorator from './PreviewDecorator.svelte';
  import CardSlider from './CardSlider.svelte';

  const defaultProps = {
    cards: [
      buildFakeEventCard(),
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
