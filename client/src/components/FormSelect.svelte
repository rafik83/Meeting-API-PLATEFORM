<style>
  input[type='search'] {
    width: calc(100% - 2.5rem);
  }
</style>

<script>
  import { _ } from 'svelte-i18n';
  import { filterCountriesByName } from '../modules/autocompletion.ts';
  import { fly } from 'svelte/transition';
  import { IconSearch } from '../ui-kit/icons/IconSearch';
  import { IconDropDown } from '../ui-kit/icons/IconDropDown';

  // options must have a "name" key who is shown in the front for select
  export let options;
  export let name;
  export let label;
  export let id;
  export let errorMessage = null;
  export let searchBar = false;
  let displaySelect = false;
  let filterOptions = options;
  let filteredCountries = [];
  let selectedLabel = '';

  const handleClick = () => {
    displaySelect = !displaySelect;
  };

  export let selectedOption;

  const handleInputSearch = (e) => {
    filteredCountries = filterCountriesByName(options, e.target.value);
    filterOptions = filteredCountries ? filteredCountries : options;
  };

  const handleClickOption = () => {
    displaySelect = !displaySelect;
    selectedLabel = selectedOption.name;
  };
</script>

<div class="relative">
  <button
    class="border bg-gray-50 rounded-3xl w-full mt-2 py-2 px-5 font-bold flex justify-between align-center {errorMessage
      ? 'border-error text-error'
      : 'border-gray-200'}"
    on:click|stopPropagation|preventDefault={handleClick}
    {label}
  >
    {selectedLabel ? selectedLabel : label}
    <IconDropDown width={25} height={25} stroke={'rgba(42, 46, 67, .7)'} />
  </button>

  {#if displaySelect}
    <div
      transition:fly={{ y: -20, duration: 250, delay: 0 }}
      class="flex flex-col justify-start items-start border rounded overflow-hidden absolute z-50 w-full bg-gray-100"
    >
      {#if searchBar}
        <input
          type="search"
          name="{label.toLowerCase()}-searchinput"
          class="border mt-3 mb-4 ml-4 mr-6 px-4 pt-3 pb-2"
          on:input={handleInputSearch}
          placeholder={$_('messages.search')}
        />
        <i class="absolute right-9 top-5 w-8 border-0">
          <IconSearch fill="rgba(42, 46, 67, .7)" width="100%" height="100%" />
        </i>
      {/if}
      <select
        {name}
        {id}
        bind:value={selectedOption}
        on:click|stopPropagation|preventDefault={handleClickOption}
        class="w-full"
        size="5"
      >
        {#each filterOptions as option, i}
          <option
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

  {#if errorMessage}
    <span class="text-error mx-2 my-5">{errorMessage}</span>
  {/if}
</div>
