<script>
  import SecondaryObjectivesHeader from './SecondaryObjectivesHeader.svelte';

  import TagButton from './TagButton.svelte';

  export let titleTag;
  export let tags;
</script>

<div class="flex flex-wrap w-full justify-left pl-7 py-4 items-center mt-4">
  <SecondaryObjectivesHeader id={titleTag.id} text={titleTag.name} />
</div>
<div class="flex flex-wrap w-full justify-center px-10 items-center">
  <div class="w-full flex flex-wrap justify-start">
    {#each tags as tag}
      <TagButton
        priority={tag.priority}
        name={tag.name}
        id={tag.id}
        sticky
        on:click
      />
    {/each}
  </div>
</div>
