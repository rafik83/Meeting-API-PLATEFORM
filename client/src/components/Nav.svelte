<script>
  import NavSearch from './NavSearch.svelte';
  import NavChat from './NavChat.svelte';
  import NavAlert from './NavAlert.svelte';
  import NavAccount from './NavAccount.svelte';
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
</script>

<header class="w-full h-14 flex justify-between">
  <a href="/" class="ml-5">
    <VimeetCommunityLogo communityName="space" />
  </a>
  <div class="xl:hidden block">
    <button
      id="menu-responsive"
      class="h-full flex items-center px-5"
      on:click={handleClick}
    >
      <MenuBurger {open} stroke="#2a2e43" />
    </button>
    <nav
      class="fixed h-full w-full z-50 bg-gray-50 {open
        ? 'right-0'
        : '-right-full'} transition-all"
    >
      <ul class="h-full w-full flex flex-col justify-start items-center">
        <li class="h-16 w-full">
          <NavSearch bind:search {searchResults} isMobile={true} />
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
  </div>
  <nav class="xl:block hidden bg-gray-50">
    <ul class="h-full px-5 flex justify-end">
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
</header>
