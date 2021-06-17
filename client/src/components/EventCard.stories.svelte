<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import PreviewDecorator from './PreviewDecorator.svelte';
  import EventCard from './EventCard.svelte';
  import { buildFakeEventCard } from '../__fixtures__/FakeCards';
</script>

<Meta title="Vimeet365/EventCard" component={EventCard} />

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
  <EventCard {...args} event={buildFakeEventCard()} locale="en" />
</Template>

<Story name="Basic" />
