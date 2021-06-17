<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import LinkCard from './LinkCard.svelte';
</script>

<Meta title="Vimeet365/LinkCard" component={LinkCard} />

<Template let:args>
  <LinkCard {...args}>Click me</LinkCard>
</Template>

<Story name="primary" args={{ kind: 'primary' }} />
<Story name="community" args={{ kind: 'community' }} />
<Story name="action" args={{ kind: 'action' }} />
