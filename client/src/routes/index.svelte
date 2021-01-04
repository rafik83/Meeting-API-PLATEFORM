<script context="module">
  import { locale as localeStore } from 'svelte-i18n';
  export async function preload() {
    let locale;
    localeStore.subscribe((value) => {
      locale = value;
    });

    return this.redirect(302, locale);
  }
</script>
