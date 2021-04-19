<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';

  import Nav from './Nav.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';
</script>

<Meta
  title="Vimeet365/Nav"
  component={Nav}
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
/>

<Template let:args>
  <Nav {...args} />
</Template>

<Story name="Base" />
<Story name="Alerts" args={{ messages: 4, alerts: 1 }} />
<Story name="Big alerts" args={{ messages: 3000, alerts: 20002 }} />
