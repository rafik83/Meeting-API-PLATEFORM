<script>
  import { IconChat } from '../ui-kit/icons';
  import Badge from './Badge.svelte';

  export let messages = 0;
</script>

<button
  class="w-28 mx-3 h-full flex items-center justify-center hover:bg-gray-100 cursor-pointer">
  <div class="relative h-full w-12 flex items-center">
    <IconChat width="34" height="34" />
    {#if messages > 0}
      <div class="absolute top-0 right-0">
        <Badge alert>{messages <= 99 ? messages : '99+'}</Badge>
      </div>
    {/if}
  </div>
</button>
