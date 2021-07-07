<style global lang="postcss">
  @font-face {
    font-family: Poppins;
    font-weight: 400;
    font-style: normal;
    src: url(/fonts/poppins-regular.woff2) format('woff2');
  }

  @font-face {
    font-family: Poppins;
    font-weight: 600;
    font-style: normal;
    src: url(/fonts/poppins-600.woff2) format('woff2');
  }

  @font-face {
    font-family: Poppins;
    font-weight: 800;
    font-style: normal;
    src: url(/fonts/poppins-800.woff2) format('woff2');
  }

  @tailwind base;
  @tailwind components;
  @tailwind utilities;

  /* Custom classe */

  .outlined:focus {
    @apply outline-none ring-1 ring-community-300;
  }

  .stripped {
    background: repeating-linear-gradient(
      -45deg,
      white,
      white 5px,
      #e8eaf1 5px,
      #e8eaf1 10px
    );
  }
</style>

<script context="module">
  import { isLoading, waitLocale } from 'svelte-i18n';
  export async function preload() {
    return waitLocale();
  }
</script>

<script>
  import Modal from 'svelte-simple-modal';
  import Loader from '../components/Loader.svelte';
  import { _ } from 'svelte-i18n';
</script>

<svelte:head>
  <title>{$_('messages.vimeet_365')}</title>
</svelte:head>

{#if $isLoading}
  <div class="w-full h-full flex justify-center items-center z-10">
    <Loader />
  </div>
{:else}
  <Modal>
    <main class="bg-gray-50 flex h-full flex-col overflow-auto items-center">
      <slot />
    </main>
  </Modal>
{/if}
