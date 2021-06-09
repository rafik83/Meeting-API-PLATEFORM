<script>
  // the component used in the story.
  export let child;
  // the props inherited from the component's story
  export let props = {};

  import { addMessages, init } from 'svelte-i18n';

  init({
    fallbackLocale: 'en',
    initialLocale: 'en',
  });

  import en from '../src/messages/en.json';

  addMessages('en', en);
</script>

<svelte:component this={child} {...props} />
