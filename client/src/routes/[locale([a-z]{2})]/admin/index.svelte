<script>
  import { _ } from 'svelte-i18n';
  import Dummy from '../../../components/Dummy.svelte';
</script>

<svelte:head>
  <title>Admin</title>
</svelte:head>
<h1>{$_('admin.title')}</h1>

<Dummy />
