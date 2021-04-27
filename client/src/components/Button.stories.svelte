<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Button from './Button.svelte';
</script>

<Meta title="Vimeet365/Button" component={Button} />

<Template let:args>
  <Button {...args}>Click me</Button>
</Template>

<Story name="primary" args={{ kind: 'primary' }} />
<Story name="secondary" args={{ kind: 'secondary' }} />
<Story name="ghost" args={{ kind: 'ghost' }} />
<Story name="tiertiary" args={{ kind: 'tiertiary' }} />
<Story name="community" args={{ kind: 'community' }} />
<Story name="ghost" args={{ kind: 'ghost' }} />
<Story name="outlined" args={{ kind: 'outlined' }} />
