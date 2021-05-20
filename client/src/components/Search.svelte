<script>
  import { fly } from 'svelte/transition';
  import FormInput from './FormInput.svelte';
  import { createEventDispatcher } from 'svelte';

  const dispatch = createEventDispatcher();

  export let id = '';
  export let label = '';
  export let name = '';
  export let options = [];
  export let errorMessage = null;
  export let value;
  export let loading;

  let displaySearch = options.length > 0;

  const handleInput = () => {
    if (options.length > 0) {
      displaySearch = true;
    }
  };

  const handleBlur = () => {
    displaySearch = false;
  };

  const handleClickOption = (option) => {
    displaySearch = false;
    dispatch('item_selected', option);
  };
</script>

<div class="relative my-5">
  <FormInput
    {loading}
    type="search"
    {label}
    {name}
    bind:value
    on:input={handleInput}
    on:input
    on:blur
    on:blur={handleBlur}
    {errorMessage}
    withMargin={false}
  />

  {#if displaySearch}
    <div
      transition:fly={{ y: -20, duration: 250, delay: 0 }}
      class="flex flex-col justify-start items-start border rounded overflow-hidden absolute z-50 w-full bg-gray-100"
    >
      <select
        {id}
        {name}
        class="w-full"
        size={options.length >= 5 ? 5 : options.length}
      >
        {#each options as option, i}
          <option
            on:click|preventDefault={() => handleClickOption(option)}
            class="{i % 2 === 0
              ? 'bg-gray-50'
              : 'bg-gray-100'} px-4 py-2 cursor-pointer"
            value={option}
          >
            {option.name}
          </option>
        {/each}
      </select>
    </div>
  {/if}
</div>
