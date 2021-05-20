<script>
  import { _ } from 'svelte-i18n';

  export let max = null;
  export let value = '';
  export let name;
  export let label;
  export let errorMessage = null;
  $: displayLabel = value ? true : false;

  $: if (max && value.length > max) {
    value = value.substring(0, max);
  }

  const handleTextareaFocusIn = () => {
    displayLabel = true;
  };
  const handleTextareaFocusOut = () => {
    if (!value) {
      displayLabel = false;
    }
  };
</script>

<div class="relative">
  <label
    for={name}
    class="transition duration-1000 ease-in-out absolute italic bg-gray-50 px-2 {displayLabel
      ? '-top-1 left-4 text-sm'
      : 'top-3 left-2 text-gray-400'}">{label}</label
  >
  <textarea
    id={name}
    class="border bg-gray-50 rounded-xl w-full h-40 mt-2 italic p-2 text-sm outlined {errorMessage
      ? 'border-error text-error'
      : 'border-gray-200'}"
    bind:value
    on:focus={handleTextareaFocusIn}
    on:focusout={handleTextareaFocusOut}
    on:input
  />

  {#if max}
    <p
      class="text-right text-xs text-gray-400 {value.length >= max
        ? 'text-error'
        : ''}"
    >
      {$_('registration.characters', { values: { n: value.length } })}
    </p>
  {/if}

  {#if errorMessage}
    <span class="text-error mx-2 my-5">{errorMessage}</span>
  {/if}
</div>
