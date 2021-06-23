<style>
  main {
    position: relative;
    max-width: 100%;
    margin: 0 auto;
    box-sizing: border-box;
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
