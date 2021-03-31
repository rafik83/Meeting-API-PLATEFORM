<script>
  export let url;
  export let isOnline;
  export let account;
</script>

<div class="relative">
  <a href="http://"
    ><img src={url} alt={account} class="rounded-full w-32 h-32" />
    {#if isOnline !== null}
      <div
        class="absolute w-3.5 h-3.5 rounded-xl border-2 border-gray-50 right-5 bottom-0 {isOnline
          ? 'bg-success'
          : 'bg-error'}"
      />
    {/if}
  </a>
</div>
