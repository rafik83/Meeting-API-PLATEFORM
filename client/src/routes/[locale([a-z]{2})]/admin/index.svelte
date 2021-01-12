<script>
  import { getTranslator } from '../../../modules/i18n';

  const _ = getTranslator();
</script>

<svelte:head>
  <title>Admin</title>
</svelte:head>
<h1>{$_('admin.title')}</h1>
