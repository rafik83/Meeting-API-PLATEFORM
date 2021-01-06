<style>
  a {
    cursor: pointer;
    text-decoration: none;
    padding: 1em 0.5em;
    display: block;
  }
</style>

<script>
  import { locale as localeStore } from 'svelte-i18n';
  import { stores } from '@sapper/app';
  const { session } = stores();
  import { _ } from 'svelte-i18n';
  export let locale;

  const handleClick = () => {
    $localeStore = locale;
    $session.locale = locale;
  };
</script>

<span on:click={handleClick}>
  <a href={locale}> {$_('languages.' + locale.replace('-', '_'))}</a>
</span>
