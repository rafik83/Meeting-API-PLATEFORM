<script>
  import { _ } from 'svelte-i18n';
  import {
    filterTagsWithNoPriorities,
    getTagsFromNomenclatureTags,
    getTagsWithPriorityCount,
    updatePriorities,
  } from '../modules/tagManagement';

  import RegistrationPipeLineHeader from './RegistrationPipeLineHeader.svelte';
  import PriorityChoiceButton from './PriorityChoiceButton.svelte';
  import Button from './Button.svelte';
  export let errorMessage;

  export let user;
  export let onNext;
  export let nomenclatureTags;
  export let min;
  export let max = null;
  export let title;

  let selectedTagCount = 0;

  const handleSelectedTag = (e) => {
    if (!max || selectedTagCount < max || e.detail.priority) {
      nomenclatureTags = updatePriorities(e.detail, nomenclatureTags);
      selectedTagCount = getTagsWithPriorityCount(nomenclatureTags);
    }
  };

  const handleNext = () => {
    errorMessage = '';
    if (selectedTagCount >= min) {
      const filteredNomenclatureTags = filterTagsWithNoPriorities(
        nomenclatureTags
      );

      const tags = getTagsFromNomenclatureTags(filteredNomenclatureTags);

      onNext(tags);
    }
    if (selectedTagCount < min) {
      errorMessage = $_('validation.not_enough_tag_selected', {
        values: {
          value: min - selectedTagCount,
        },
      });
    }
  };
</script>

<div class="w-full px-8 py-2 mx-auto my-5 flex-col items-center">
  <RegistrationPipeLineHeader
    title={$_('registration.hello') + '.'}
    subtitle={user.firstName + ' ' + user.lastName}
  />

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
      {$_('registration.selected', {
        values: { n: selectedTagCount, priorities_number: max },
      })}
    </p>
  {/if}

  {#if errorMessage}
    <p class="text-error m-3">{errorMessage}</p>
  {/if}
  <div class="flex flex-col mt-4 items-center">
    {#each nomenclatureTags as { tag }}
      <PriorityChoiceButton
        priority={tag.priority}
        name={tag.name}
        id={tag.id}
        on:click={handleSelectedTag}
      />
    {/each}

    <Button on:click={handleNext} kind="primary" type="submit"
      >{$_('registration.next')}</Button
    >
  </div>
</div>
