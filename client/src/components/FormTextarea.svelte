<script>
  import { _ } from 'svelte-i18n';

  export let max = null;
  export let value;
  export let placeholder;
  export let errorMessage = null;

  $: if (max && value.length > max) {
    value = value.substring(0, max);
  }
</script>

<textarea
  class="border bg-gray-50 rounded-xl w-full h-40 mt-2 italic p-2 text-sm {errorMessage
    ? 'border-error text-error'
    : 'border-gray-200'}"
  bind:value
  {placeholder}
/>

{#if max}
  <p>
    {$_('registration.characters', { values: { n: value.length } })}
  </p>
{/if}
