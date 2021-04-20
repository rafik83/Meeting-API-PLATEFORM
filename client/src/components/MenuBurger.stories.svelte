<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import MenuBurger from './MenuBurger.svelte';
</script>

<Meta title="Vimeet365/MenuBurger" component={MenuBurger} />

<Template let:args>
  <MenuBurger {...args} />
</Template>

<Story name="Close" args={{ open: false }} />
<Story name="Open" args={{ open: true }} />
