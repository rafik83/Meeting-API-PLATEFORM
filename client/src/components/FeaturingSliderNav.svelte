<script>
  export let numberOfSlides;
  export let currentIndex = 0;
</script>

<div class="flex p-2 z-0">
  {#each Array(numberOfSlides) as _, key}
    <div
      class="xl:w-10 xl:h-1 xl:mx-1 w-7 h-0.5 mx-0.5  {currentIndex === key
        ? 'bg-gray-50'
        : 'bg-gray-200'}"
    />
  {/each}
</div>
