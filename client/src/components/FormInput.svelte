<style>
  input:focus::placeholder {
    color: transparent;
  }

  input::placeholder {
    font-style: italic;
  }
</style>

<script>
  import { IconEye } from './icons/IconEye';

  export let displayLabel = false;

  const handleFocusInput = () => {
    displayLabel = true;
  };

  const handleMouseOut = () => {
    if (!value) {
      displayLabel = false;
    }
  };

  export let name;
  export let type;
  export let label;
  export let value;
  export let errorMessage = null;
  export let options = null;
  export let datalistName = null;
  let displayPassword = false;

  const toggle = (event) => {
    const input = event.currentTarget.previousElementSibling;
    if (!input) {
      return;
    }

    input.type = input.type === 'password' ? 'text' : 'password';
    displayPassword = !displayPassword;
  };

  const handleInput = (event) => {
    value = event.target.value;
  };

  const inputWidth = type === 'password' ? 'w-11/12' : 'w-full';
</script>

<div class="my-5">
  <div
    class="border flex rounded-3xl  {errorMessage
      ? 'border-error'
      : 'border-gray-200'}"
  >
    <label
      class:invisible={!displayLabel}
      for={name}
      class="block -mt-3.5 italic absolute bg-gray-50 mf-2.5 ml-3 px-2 text-sm {errorMessage
        ? 'border-error text-error'
        : 'border-gray-200'}">{label}</label
    >

    <input
      {type}
      id={name}
      {value}
      placeholder={label}
      list={datalistName}
      on:focusout={handleMouseOut}
      on:focus={handleFocusInput}
      on:input={handleInput}
      class={`text-grey rounded-3xl px-4 py-2 border-none ${inputWidth}`}
      autocomplete="on"
    />

    {#if options}
      <datalist id={datalistName}>
        {#each options as option}
          <option data-id={option.id} value={option.name} />
        {/each}
      </datalist>
    {/if}

    {#if type === 'password'}
      <button
        tabIndex="-1"
        on:click|preventDefault={toggle}
        class="w-5 h-auto mx-2">
        <IconEye fill="#cccc" />
      </button>
    {/if}
  </div>
  {#if errorMessage}
    <span class="text-error mx-2 my-5">{errorMessage}</span>
  {/if}
</div>
