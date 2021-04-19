<script>
  import NavSearch from './NavSearch.svelte';
  import NavChat from './NavChat.svelte';
  import NavAlert from './NavAlert.svelte';
  import NavAccount from './NavAccount.svelte';
  import { onMount } from 'svelte';
  import MenuBurger from './MenuBurger.svelte';
  import VimeetCommunityLogo from './VimeetCommunityLogo.svelte';

  export let search = '';
  export let searchResults = [];
  export let messages = 0;
  export let alerts = 0;
  export let user;

  let open = false;
  const handleClick = () => {
    open = !open;
  };

  let isMobile = false;
  const checkWindowSize = () => {
    if (window.innerWidth < 1200) {
      isMobile = true;
    } else {
      isMobile = false;
    }
  };

  onMount(() => {
    checkWindowSize();
  });
</script>

<svelte:window on:resize={checkWindowSize} />

<header class="w-full flex justify-between">
  <div class="ml-5">
    <VimeetCommunityLogo communityName="space" />
  </div>
  {#if !isMobile}
    <nav class="bg-gray-50">
      <ul class="h-14 px-5 flex justify-end">
        <li>
          <NavSearch bind:search {searchResults} />
        </li>
        <li>
          <NavChat {messages} />
        </li>
        <li>
          <NavAlert {alerts} />
        </li>
        <li>
          <NavAccount {user} />
        </li>
      </ul>
    </nav>
  {:else}
    <nav class="fixed top-0 right-0 left-0 bottom-0">
      <button
        id="menu-responsive"
        class="absolute right-0 z-20 mr-7 mt-7"
        on:click={handleClick}>
        <MenuBurger {open} stroke="#2a2e43" />
      </button>
      <div
        class="absolute w-full h-full bg-gray-100 z-10 {open
          ? 'right-0'
          : '-right-full'} transition-all"
      >
        <ul class="h-full w-full flex flex-col justify-start items-center">
          <li class="h-16 w-full">
            <NavSearch bind:search {searchResults} {isMobile} />
          </li>
          <li>
            <NavChat {messages} />
          </li>
          <li>
            <NavAlert {alerts} />
          </li>
          <li>
            <NavAccount {user} />
          </li>
        </ul>
      </div>
    </nav>
  {/if}
</header>
