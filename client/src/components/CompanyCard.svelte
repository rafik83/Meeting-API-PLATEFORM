<script>
  import { _ } from 'svelte-i18n';

  import { createEventDispatcher } from 'svelte';
  import ButtonCard from './ButtonCard.svelte';
  import IconArrowRight from '../ui-kit/icons/IconArrowRight/IconArrowRight.svelte';
  import { slide } from 'svelte/transition';
  import { ellipse } from '../modules/textUtils';
  import PicturePlaceholder from './PicturePlaceholder.svelte';

  export let name;
  export let picture;
  export let activity;
  export let id;

  let expand = false;

  const dispatch = createEventDispatcher();
</script>

<div
  on:mouseenter={() => (expand = true)}
  on:mouseleave={() => (expand = false)}
  class="w-96 bg-gray-50 shadow-full"
>
  <div>
    <div class="h-40">
      {#if picture}
        <img
          class="h-full w-full object-cover"
          src={picture}
          alt={`company-${name}-logo`}
        />

        <div class="bg-gray-100 h-0.5" />
      {:else}
        <PicturePlaceholder textContent={name} />
      {/if}
    </div>

    <div class=" p-4 flex justify-end">
      <ButtonCard
        id={`genereate-leads-${id}-button`}
        on:click={() =>
          dispatch('generate_new_leads', {
            id,
          })}
        kind={'community'}
      >
        <div class="flex">
          <span class="pr-4 flex items-center">{$_('cards.new_leads')}</span>
          <IconArrowRight fill="white" class="w-2" />
        </div>
      </ButtonCard>
    </div>
    {#if expand && activity}
      <p class="p-4 text-sm overflow-ellipsis" transition:slide>
        {ellipse(activity, 200)}
      </p>
    {/if}
  </div>
</div>
