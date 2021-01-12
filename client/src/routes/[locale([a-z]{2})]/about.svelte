<script>
  import { getTranslator } from '../../modules/i18n';
  const _ = getTranslator();
</script>

<svelte:head>
  <title>About</title>
</svelte:head>
<h1>{$_('nav.about')}</h1>
