<script context="module">
  import { _ } from 'svelte-i18n';
  export async function preload(page) {
    const queryParam = page.query;

    let errorMessage;

    _.subscribe((format) => {
      errorMessage = format('onboarding.bad_token_provided');
    });

    if (!queryParam || !queryParam.userId || !queryParam.token) {
      this.error(400, errorMessage);
    }

    return { ...queryParam };
  }
</script>

<script>
  import { onMount } from 'svelte';
  import {
    checkToken,
    requestAccountValidationEmail,
  } from '../../../repository/account';
  import Loader from '../../../components/Loader.svelte';
  import Link from '../../../components/Link.svelte';
  import { toHomePage } from '../../../modules/routing';
  import IconVimeet365 from '../../../ui-kit/icons/IconVimeet365/IconVimeet365.svelte';
  import Button from '../../../components/Button.svelte';
  import { setBaseUrl } from '../../../modules/axios';
  import { stores } from '@sapper/app';

  export let userId;
  export let token;
  let loading = true;
  let hasBadTokenError = false;

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  onMount(async () => {
    try {
      await checkToken(userId, token);
    } catch (error) {
      if (!error.response) {
        console.error(error);
        return;
      }
      if (error.response.status === 400) {
        hasBadTokenError = true;
      }

      if (error.response.status > 201) {
        hasBadTokenError = true;
      }
    } finally {
      loading = false;
    }
  });
</script>

{#if loading}
  <div class="w-full h-full flex justify-center items-center">
    <Loader />
  </div>
{:else}
  <div class="mt-5 flex justify-center items-center flex-col">
    {#if hasBadTokenError}
      <p class="text-error font-bold flex justify-center flex-col">
        {$_('onboarding.bad_token_provided')}

        <Button on:click={async () => requestAccountValidationEmail(userId)}
          >{$_('onboarding.get_new_validation_email')}</Button
        >
      </p>
    {:else}
      <IconVimeet365 height="200px" />
      <p class="my-5">
        {$_('onboarding.succeed')}
      </p>
      <Link to={toHomePage()}>{$_('onboarding.join_your_community')}</Link>
    {/if}
  </div>
{/if}
