<script>
  import IconPicturePlaholder from '../ui-kit/icons/IconPicturePlaholder/IconPicturePlaholder.svelte';
  export let textContent = null;
</script>

<div class="w-full h-full">
  <div class="flex flex-col items-center justify-center content-center">
    <IconPicturePlaholder class="" width="80px" />
    {#if textContent}
      <p class="text-gray-400 font-bold pr-4">{textContent}</p>
    {/if}
  </div>

  <div class="stripped mt-3 h-8 w-full" />
</div>
