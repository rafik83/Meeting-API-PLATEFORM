<script>
  export let options;
  export let name;
  export let optionsTitle;
  export let id;
  export let errorMessage = null;
</script>

<!-- svelte-ignore a11y-no-onchange -->
<select
  {name}
  {id}
  on:change
  class="border bg-gray-50 rounded-3xl w-full mt-2 p-2 text-sm font-bold {errorMessage
    ? 'border-error text-error'
    : 'border-gray-200'}">
  <option value={null}>{optionsTitle}</option>
  {#each options as option}
    <option value={option.id}>{option.name}</option>
  {/each}
</select>
{#if errorMessage}
  <span class="text-error mx-2 my-5">{errorMessage}</span>
{/if}
