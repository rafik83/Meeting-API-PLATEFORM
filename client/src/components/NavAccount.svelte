<script>
  import { _ } from 'svelte-i18n';
  import { goto } from '@sapper/app';

  import IconDropDown from './IconDropdown.svelte';
  import IconUser from '../ui-kit/icons/IconUser/IconUser.svelte';
  import Badge from './Badge.svelte';
  import { toRegistrationStep } from '../modules/routing';
  import { registrationSteps } from '../constants';

  export let user;
</script>

<div class="h-full pt-2 pb-3 px-3 flex hover:bg-gray-100">
  {#if user}
    <button
      type="button"
      id="nav-button-account"
      class="w-80 h-full flex justify-between"
    >
      <div class="h-full flex">
        <IconUser width="38" fill="#c4cbdc" />
        <div
          class="h-full flex items-end capitalize font-semibold text-sm ml-4"
        >
          {user.firstName}
          {user.lastName}
        </div>
        <div class="h-full flex items-start">
          <Badge community>{$_('account.connected')}</Badge>
        </div>
      </div>
      <div class="h-full flex items-end">
        <IconDropDown width="35" />
      </div>
    </button>
  {:else}
    <button
      type="button"
      id="join-community"
      class="w-80 h-full flex justify-between"
      on:click={() => goto(toRegistrationStep(registrationSteps.SIGN_IN))}
    >
      <div class="h-full flex">
        <IconUser width="38" fill="#c4cbdc" />
        <div class="h-full flex items-end uppercase font-semibold text-sm ml-4">
          {$_('registration.sign_in')}
        </div>
        <div class="h-full flex items-start">
          <Badge community>{$_('account.free')}</Badge>
        </div>
      </div>
      <div class="h-full flex items-end">
        <IconDropDown width="35" />
      </div>
    </button>
  {/if}
</div>
