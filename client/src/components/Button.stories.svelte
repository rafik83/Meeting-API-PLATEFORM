<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Button from './Button.svelte';

  const kinds = [
    'primary',
    'secondary',
    'ghost',
    'ternary',
    'community',
    'ghost',
    'outlined',
  ];
</script>

<Meta title="Vimeet365/Button" component={Button} />

<Template let:args>
  <Button />
</Template>

{#each kinds as kind}
  <Story name={kind} args={{ kind }} />
{/each}
