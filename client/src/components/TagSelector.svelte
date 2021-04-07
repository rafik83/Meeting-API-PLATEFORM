<script>
  import { _ } from 'svelte-i18n';
  import {
    filterTagsWithNoPriorities,
    setTagPriorityToNullIfNotDefined,
    updatePriorities,
  } from '../modules/tagManagement';

  import TagButton from './TagButton.svelte';
  export let errorMessage;
  export let tags;
  export let max = null;
  export let title;
  export let selectedTags;

  $: tags = setTagPriorityToNullIfNotDefined(tags);

  let selectedTagCount = 0;

  const handleSelectedTag = (e) => {
    if (!max || selectedTagCount < max || e.detail.priority) {
      tags = updatePriorities(e.detail, tags);
      selectedTags = filterTagsWithNoPriorities(tags);
      selectedTagCount = selectedTags.length;
    }
  };
</script>

<div class="w-full px-8 py-2 mx-auto my-5">
  {#if title}
    <h3 class="font-semibold text-center my-4">
      {title}
    </h3>
  {/if}

  {#if max}
    <p
      class="text-right mb-4 text-sm {selectedTagCount === max
        ? 'text-success'
        : ''}"
    >
      {$_('onboarding.selected', {
        values: { n: selectedTagCount, priorities_number: max },
      })}
    </p>
  {/if}

  {#if errorMessage}
    <p class="text-error my-5">{errorMessage}</p>
  {/if}
  <div class="flex-wrap md:flex">
    {#each tags as tag}
      <div class="md:w-1/2">
        <TagButton
          priority={tag.priority}
          name={tag.name}
          id={tag.id}
          on:click={handleSelectedTag}
        />
      </div>
    {/each}
  </div>
</div>
