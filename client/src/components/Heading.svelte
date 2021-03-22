<script>
  export let type;
  export let content;
</script>

{#if type === 'h1'}
  <h1 class="md:text-5xl text-4xl font-bold my-1 text-gray-500">
    {content}
  </h1>
{:else if type === 'h2'}
  <h2 class="md:text-2xl text-xl font-bold my-1 text-community-300">
    <slot>{content}</slot>
  </h2>
{:else if type === 'h3'}
  <h3 class="md:text-xl text-l font-bold my-1 text-community-300">
    <slot>{content}</slot>
  </h3>
{:else if type === 'h4'}
  <h4 class="md:text-l text-m font-bold my-1 text-gray-500">
    <slot>{content}</slot>
  </h4>
{:else if type === 'h4-community'}
  <h4
    class="md:text-l text-m font-bold my-5 p-2 bg-gray-100 text-community-300"
  >
    <slot>{content}</slot>
  </h4>
{/if}
