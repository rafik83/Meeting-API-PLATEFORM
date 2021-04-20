<script>
  import H2 from './H2.svelte';
  import TagButton from './TagButton.svelte';
  import IconTitle from '../ui-kit/icons/IconTitle/IconTitle.svelte';

  export let titleTag;
  export let tags;
</script>

<div class="flex flex-wrap w-full justify-left pl-7 py-4 items-center mt-4">
  <div class="flex">
    <IconTitle fill="#c4cbdc" class="w-5" />
  </div>

  <div class="flex flex-col w-11/12 mx-3 -mt-4">
    <H2 id={titleTag.id}>{titleTag.name}</H2>
    <div class="h-0.5 w-full bg-gray-200" />
  </div>
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
