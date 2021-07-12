<script>
  import { _ } from 'svelte-i18n';
  import Tag from './Tag.svelte';
  import { slide } from 'svelte/transition';
  import LinkCard from './LinkCard.svelte';
  import { formatEventCardDate } from '../modules/date';
  import IconArrowRight from '../ui-kit/icons/IconArrowRight/IconArrowRight.svelte';
  import IconCalendar from '../ui-kit/icons/IconCalendar/IconCalendar.svelte';
  import IconMore from '../ui-kit/icons/IconMore/IconMore.svelte';
  import PicturePlaceholder from './PicturePlaceholder.svelte';

  export let picture;
  export let name;
  export let eventType;
  export let startDate;
  export let endDate;
  export let registerUrl;
  export let findOutMoreUrl;
  export let tags;

  let show = false;
</script>

<div
  on:mouseenter={() => (show = true)}
  on:mouseleave={() => (show = false)}
  class="w-96 bg-gray-50 shadow-full"
>
  <div class="flex relative h-44 overflow-hidden">
    {#if picture}
      <img
        class="w-full object-cover overflow-hidden"
        src={picture}
        alt={`${name} image`}
      />
    {:else}
      <PicturePlaceholder textContent={name} />
    {/if}
    <span
      class="absolute top-0 left-0 bg-gray-50 text-community-400 text-xs px-2 pt-0.5 font-bold uppercase"
      >{eventType}</span
    >
  </div>
  <div class="bg-gray-100 h-0.5" />

  {#if show}
    <div class="flex justify-between px-4 py-2">
      <LinkCard href={findOutMoreUrl} kind="action">
        <div class="flex items-center h-full">
          <span class="pr-4">{$_('cards.find_out_more')}</span>
          <IconMore />
        </div>
      </LinkCard>
      <LinkCard href={registerUrl} kind="community">
        <div class="flex items-center h-full">
          <span class="pr-4">{$_('registration.register')}</span>
          <IconArrowRight width="15px" heigth="15px" />
        </div>
      </LinkCard>
    </div>
    <div class="w-full px-4 py-2 my-2 flex items-center">
      <div
        class="flex items-center justify-center w-8 h-8 bg-community-300 rounded-full"
      >
        <IconCalendar fill="#fff" class="w-3" />
      </div>
      <span class="ml-2 uppercase text-community-300 font-bold text-lg"
        >{@html formatEventCardDate(startDate, endDate)}</span
      >
    </div>
  {:else}
    <div class="flex justify-end px-4 py-2">
      <LinkCard href={registerUrl} kind="community">
        <div class="flex items-center h-full">
          <span class="pr-4">{$_('registration.register')}</span>
          <IconArrowRight width="15px" heigth="15px" />
        </div>
      </LinkCard>
    </div>
  {/if}

  {#if show}
    <div class="flex flex-wrap px-4 pb-2" transition:slide>
      {#each tags as tag}
        <Tag dark={false}>{tag.name}</Tag>
      {/each}
    </div>
  {/if}
</div>
