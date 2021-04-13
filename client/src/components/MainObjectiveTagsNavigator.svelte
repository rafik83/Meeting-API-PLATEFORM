<script>
  export let tags;
  let selected = 0;
</script>

<div
  class="flex flex-wrap w-full justify-center px-7 py-4 items-center mb-6 bg-gray-100 mt-4"
>
  {#each tags as tag, i}
    <a
      href="#{tag.name}"
      class="px-7 py-2 m-2 shadow-full max-w-sm font-semibold uppercase rounded-full truncate"
      on:click={() => (selected = i)}
      class:bg-community-300={selected === i}
      class:text-gray-50={selected === i}>
      {tag.name}
    </a>
  {/each}
</div>
