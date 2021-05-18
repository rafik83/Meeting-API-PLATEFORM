<script>
  import { IconEye } from '../ui-kit/icons/IconEye';

  export let name;
  export let type;
  export let value;
  export let id = name;
  export let label = '';
  export let errorMessage = null;
  export let options = null;
  export let datalistName = null;
  let displayLabel = value ? true : false;

  const handleFocusInput = () => {
    displayLabel = true;
  };

  const handleFocusOut = () => {
    if (!value) {
      displayLabel = false;
    }
  };

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

  const inputWidthClasse = type === 'password' ? 'w-11/12' : 'w-full';

  $: labelErrorClasses = errorMessage ? 'text-error' : 'boder-gray-200';

  $: labeClasses = displayLabel ? '-top-3 left-2 text-sm' : 'top-1.5 text-base';
</script>

<div class="my-5">
  <div
    class="border flex rounded-3xl relative {errorMessage
      ? 'border-error'
      : 'border-gray-200'}"
  >
    <label
      for={id}
      class="block transition-all duration-250 italic absolute bg-gray-50 mf-2.5 ml-3 px-2 {labelErrorClasses} {labeClasses} "
    >
      {label}
    </label>

    <input
      {type}
      {id}
      {value}
      {name}
      list={datalistName}
      on:focusout={handleFocusOut}
      on:focus={handleFocusInput}
      on:input={handleInput}
      on:input
      class="text-grey rounded-3xl px-4 py-2 outlined {inputWidthClasse}"
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
        type="button"
        on:click|preventDefault={toggle}
        tabindex="-1"
        class="w-5 h-auto mx-2"
      >
        <IconEye fill="#cccc" />
      </button>
    {/if}
  </div>
  {#if errorMessage}
    <span class="text-error mx-2 my-5">{errorMessage}</span>
  {/if}
</div>
