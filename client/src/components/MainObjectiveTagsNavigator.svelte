<script>
  export let tags;
  let selectedTagId = tags[0].id;
  const handleClick = (tag) => {
    selectedTagId = tag.id;
    location.hash = `#${tag.id}`;
  };
</script>

<div
  class="flex flex-wrap w-full justify-center px-7 py-4 items-center mb-6 bg-gray-100 mt-4"
>
  {#each tags as tag}
    <a
      href="#{tag.id}"
      class="px-7 py-2 m-2 shadow-full max-w-sm font-semibold uppercase rounded-full truncate"
      on:click|preventDefault={() => handleClick(tag)}
      class:bg-community-300={selectedTagId === tag.id}
      class:text-gray-50={selectedTagId === tag.id}>
      {tag.name}
    </a>
  {/each}
</div>
