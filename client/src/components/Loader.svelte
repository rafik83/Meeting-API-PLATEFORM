<script>
  import { _ } from 'svelte-i18n';
  import IconLoader from '../ui-kit/icons/IconLoader/IconLoader.svelte';
  export let title = $_('messages.loading');
  export let message = '';
</script>

<div
  class="text-gray-400 w-full h-full flex flex-col items-center justify-center"
>
  <p class="text-l md:text-xl font-bold">{title}</p>

  {#if message}
    <p class="mt-2">{message}</p>
  {/if}

  <IconLoader width="30" class="mt-5 animate-spin" />
</div>
