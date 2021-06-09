<script>
  import { _ } from 'svelte-i18n';
  import MemberAvatar from './MemberAvatar.svelte';
  import IconUser from '../ui-kit/icons/IconUser1/IconUser1.svelte';
  import IconVideo from '../ui-kit/icons/IconVideo/IconVideo.svelte';
  import Tag from './Tag.svelte';
  import { slide } from 'svelte/transition';
  import { getFlagIconFromIsoCode } from '../modules/getFlagUnicode.ts';
  import ButtonCard from './ButtonCard.svelte';
  import AvatarPlaceHolder from './AvatarPlaceHolder.svelte';
  import { createEventDispatcher } from 'svelte';
  import { slugify } from '../modules/textUtils';

  const dispatch = createEventDispatcher();

  export let picture;
  export let firstName;
  export let lastName;
  export let languageCodes;
  export let mainGoal;
  export let secondaryGoal;
  export let goals;
  export let id;
  export let companyName;
  export let jobPosition;

  let expand = false;
  let status = false;
  let flags = languageCodes.map(getFlagIconFromIsoCode).filter((item) => item);
</script>

<div
  on:mouseenter={() => (expand = true)}
  on:mouseleave={() => (expand = false)}
  class="w-96 bg-gray-50 shadow-full"
>
  <div class="h-42">
    <div class="flex px-4 pt-8 pb-4">
      <div>
        {#if picture}
          <MemberAvatar
            pictureUrl={picture}
            fullName="{firstName} {lastName}"
            {id}
          />
        {:else}
          <AvatarPlaceHolder {firstName} {lastName} />
        {/if}
      </div>
      <div class="w-2/4 pl-4">
        <p class="font-bold">{firstName} {lastName}</p>
        <p class="text-gray-300 leading-3">{jobPosition}</p>
        <p>{companyName}</p>

        {#if flags.length > 0}
          <p class="pt-2">
            {#each flags as flag}
              <span class="pr-1">{flag}</span>
            {/each}
          </p>
        {/if}
      </div>
    </div>
    <div class="bg-gray-100 h-0.5" />
  </div>

  <div class="flex justify-between px-4 py-2">
    <div class:invisible={!expand && mainGoal && secondaryGoal}>
      <ButtonCard
        id={slugify(`view-${firstName}-${lastName}-profile-button`)}
        on:click={() =>
          dispatch('view_member_profile', {
            firstName,
            lastName,
            id,
          })}
        kind="action"
      >
        <div class="flex">
          <span class="pr-4 flex items-center">{$_('cards.view_profile')}</span>
          <IconUser fill="#2A2E43" class="w-4" />
        </div>
      </ButtonCard>
    </div>

    <ButtonCard
      kind="community"
      id={slugify(`meet-${firstName}-${lastName}-button`)}
      on:click={() =>
        dispatch('meet_member', {
          firstName,
          lastName,
        })}
    >
      <div class="flex">
        <span class="pr-4">{$_('cards.meet')}</span>
        <IconVideo fill="#FFF" class="w-6" />
      </div>
    </ButtonCard>
  </div>

  {#if expand && mainGoal && secondaryGoal}
    <div class="px-4 pb-2 pt-5 {status}" transition:slide>
      <div class="flex">
        <Tag highlight>{mainGoal.name}</Tag><Tag>{secondaryGoal.name}</Tag>
      </div>
      <div class="flex flex-wrap">
        {#each goals as goal}
          <Tag>{goal.name}</Tag>
        {/each}
      </div>
    </div>
  {/if}
</div>
