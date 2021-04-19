<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Loader from './Loader.svelte';
</script>

<Meta title="Vimeet365/Loader" component={Loader} />

<Template let:args>
  <Loader />
</Template>

<Story name="Normal" />
