<script>
  import { toMemberPage } from '../modules/routing';

  export let pictureUrl;
  export let isOnline = null;
  export let fullName;
  export let id;
</script>

<div class="relative">
  <a href={toMemberPage(id)}
    ><img
      src={pictureUrl}
      alt={fullName}
      class="object-contain rounded-full w-32 h-32"
    />
    {#if isOnline !== null}
      <div
        class="absolute w-3.5 h-3.5 rounded-xl border-2 border-gray-50 right-5 bottom-0 {isOnline
          ? 'bg-success'
          : 'bg-error'}"
      />
    {/if}
  </a>
</div>
