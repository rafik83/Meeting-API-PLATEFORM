<script>
  // the component used in the story.
  export let child;
  // the props inherited from the component's story
  export let props = {};

  import { addMessages, init } from 'svelte-i18n';

  init({
    fallbackLocale: 'fr',
    initialLocale: 'fr',
  });

  import fr from '../src/messages/fr.json';

  addMessages('fr', fr);
</script>

<svelte:component this={child} {...props} />
