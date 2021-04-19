<script>
  import IconSearch from '../ui-kit/icons/IconSearch/IconSearch.svelte';
  import { fly, scale } from 'svelte/transition';
  import { _ } from 'svelte-i18n';

  export let search = '';
  export let searchResults = [];
  export let isMobile = false;

  let displaySearch = false;
  let uniq = {};
  const handleMouseEnter = () => {
    displaySearch = true;
    if (!search) {
      uniq = {};
    }
  };

  const handleMouseLeave = () => {
    if (!search) {
      displaySearch = false;
    }
  };

  const handleClick = () => {
    displaySearch = true;
  };
</script>

{#if !isMobile}
  <div
    on:mouseenter={handleMouseEnter}
    on:mouseleave={handleMouseLeave}
    on:click={handleClick}
    transition:scale
    class="bg-gray-100 flex items-center justify-center h-full relative"
  >
    {#key uniq}
      <button
        class="w-28 h-full flex justify-center items-center"
        in:fly={{ x: 200, duration: 500, delay: 0 }}>
        <IconSearch fill="#2A2E43" width="70%" height="70%" />
      </button>
    {/key}

    {#if displaySearch}
      <input
        class="px-5 h-full bg-gray-100"
        type="search"
        bind:value={search}
        placeholder={$_('messages.search')}
      />
    {/if}
    {#if searchResults}
      {searchResults}
    {/if}
  </div>
{:else}
  <div class="bg-gray-100 flex items-center justify-center h-full relative">
    <input
      class="px-5 h-full bg-gray-100"
      type="search"
      bind:value={search}
      placeholder={$_('messages.search')}
    />
    {#if searchResults}
      {searchResults}
    {/if}
  </div>
{/if}
