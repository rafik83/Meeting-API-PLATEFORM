<script>
  import { IconAlert } from '../ui-kit/icons';
  import Badge from './Badge.svelte';

  export let alerts = 0;
  let alertNumber = alerts <= 99 ? alerts : '99+';
</script>

<button
  class="w-28 mr-3 h-full flex items-center justify-center hover:bg-gray-100 cursor-pointer">
  <div class="relative h-full w-12 flex items-center">
    <IconAlert width="40" height="40" />
    {#if alerts > 0}
      <div class="absolute top-0 right-0">
        <Badge alert>{alertNumber}</Badge>
      </div>
    {/if}
  </div>
</button>
