<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Badge from './Badge.svelte';
</script>

<Meta title="Vimeet365/Badge" component={Badge} />

<Template let:args>
  <Badge {...args}>free</Badge>
</Template>

<Story name="Alert" args={{ alert: true }} />
<Story name="Community" args={{ community: true }} />
