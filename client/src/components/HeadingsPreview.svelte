<script>
  import H1 from './H1.svelte';
  import H2 from './H2.svelte';
  import H3 from './H3.svelte';
  import H4 from './H4.svelte';

  const headings = [H1, H2, H3, H4];
  export let community = false;
</script>

{#each headings as heading}
  <svelte:component this={heading} {community}
    >{community
      ? 'Community ' + heading.name
      : 'Je suis un ' + heading.name}</svelte:component
  >
{/each}
