<script>
  export let type;
  export let content;
</script>

{#if type === 'h1'}
  <h1
    data-testid="heading"
    class="md:text-5xl text-4xl  font-bold my-1 text-gray-500"
  >
    {content}
  </h1>
{:else if type === 'h2'}
  <h2 class="md:text-2xl text-xl font-bold my-1 text-community-300">
    {content}
  </h2>
{/if}
