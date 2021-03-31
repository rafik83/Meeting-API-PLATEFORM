<script>
  import { _ } from 'svelte-i18n';
  import MemberAvatar from './MemberAvatar.svelte';
  import IconUser from '../ui-kit/icons/IconUser1/IconUser1.svelte';
  import IconVideo from '../ui-kit/icons/IconVideo/IconVideo.svelte';
  import Tag from './Tag.svelte';
  import { slide } from 'svelte/transition';
  import { getFlagIconFromIsoCode } from '../modules/getFlagUnicode.ts';
  import ButtonCard from './ButtonCard.svelte';

  let show = false;
  let status = false;

  function toggleShow() {
    show = !show;
  }

  export let account;
  export let url;
  export let isOnline;
  export let matchingPourcentage;
  export let tags;

  const primaryGoal = tags.shift();
  const secondyGoal = tags.shift();

  let flags = [];

  if (account.languages && account.languages.length > 0) {
    flags = account.languages.map((isoCode) => {
      return getFlagIconFromIsoCode(isoCode);
    });
  }
</script>

<div
  on:mouseenter={toggleShow}
  on:mouseleave={toggleShow}
  class="w-96 shadow-full"
>
  <div class="flex px-4 pt-8 pb-4">
    <div>
      <MemberAvatar
        {url}
        {isOnline}
        account="{account.firstName}.{account.lastName}"
      />
    </div>
    <div class="w-2/4 pl-4">
      <p class="text-success font-bold text-base">
        {$_('cards.match', { values: { percent: matchingPourcentage } })}
      </p>
      <p class="font-bold">{account.firstName} {account.lastName}</p>
      <p class="text-gray-300 leading-3">{account.jobPosition}</p>
      <p>{account.company}</p>
      <p class="pt-2">
        {#each flags as flag}
          <span class="pr-1">{flag}</span>
        {/each}
      </p>
    </div>
  </div>
  <div class="bg-gray-100 h-0.5" />

  {#if show}
    <div class="flex justify-between px-4 py-2">
      <ButtonCard kind="action">
        <div class="flex">
          <span class="pr-4 flex items-center">{$_('cards.view_profile')}</span>
          <IconUser fill="#2A2E43" class="w-4" />
        </div>
      </ButtonCard>

      <ButtonCard kind="community">
        <div class="flex">
          <span class="pr-4">{$_('cards.meet')}</span>
          <IconVideo fill="#FFF" class="w-6" />
        </div>
      </ButtonCard>
    </div>
  {:else}
    <div class="flex justify-end px-4 py-2">
      <ButtonCard kind="community">
        <div class="flex">
          <span class="pr-4">{$_('cards.meet')}</span>
          <IconVideo fill="#FFF" class="w-6" />
        </div>
      </ButtonCard>
    </div>
  {/if}

  {#if show}
    <div class="px-4 pb-2 pt-5 {status}" transition:slide>
      <div class="flex">
        <Tag highlight>{primaryGoal.name}</Tag><Tag>{secondyGoal.name}</Tag>
      </div>
      <div class="flex flex-wrap">
        {#each tags as tag}
          <Tag>{tag.name}</Tag>
        {/each}
      </div>
    </div>
  {/if}
</div>
