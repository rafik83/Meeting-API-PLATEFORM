<script>
  import { _ } from 'svelte-i18n';

  export let max = null;
  export let value;
  export let name;
  export let label;
  export let placeholder;
  export let errorMessage = null;
  let moveLabel = false;

  $: if (max && value.length > max) {
    value = value.substring(0, max);
  }

  const handleTextareaFocusIn = () => {
    moveLabel = true;
  };
  const handleTextareaFocusOut = () => {
    if (value.length === 0) {
      moveLabel = false;
    }
  };
</script>

<div class="relative">
  <label
    for={name}
    class="absolute italic bg-gray-50 px-2 {moveLabel
      ? '-top-1 left-4 text-sm'
      : 'top-3 left-2'}">{label}</label
  >
  <textarea
    id={name}
    class="border bg-gray-50 rounded-xl w-full h-40 mt-2 italic p-2 text-sm {errorMessage
      ? 'border-error text-error'
      : 'border-gray-200'}"
    bind:value
    {placeholder}
    on:focus={handleTextareaFocusIn}
    on:focusout={handleTextareaFocusOut}
  />

  {#if max}
    <p class="text-right {value.length >= max ? 'text-error' : ''}">
      {$_('registration.characters', { values: { n: value.length } })}
    </p>
  {/if}

  {#if errorMessage}
    <span class="text-error mx-2 my-5">{errorMessage}</span>
  {/if}
</div>
