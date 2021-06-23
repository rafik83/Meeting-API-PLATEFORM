<script context="module">
  import { toCongratsPage, toHomePage } from '../../../modules/routing';
  import {
    findById,
    requestAccountValidationEmail,
  } from '../../../repository/account';

  export async function preload(page, { isAuthenticated, userId }) {
    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }

    let user;
    try {
      user = await findById(userId);

      if (user.validated) {
        this.redirect(302, toCongratsPage());
      }
    } catch (error) {
      if (error.response && error.response.status > 201) {
        console.error(error);
      }
    }

    return {
      userId,
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';
  import { stores } from '@sapper/app';
  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import IconSatellites from '../../../ui-kit/icons/IconSatellites/IconSatellites.svelte';
  import Button from '../../../components/Button.svelte';

  import { onMount } from 'svelte';
  import Loader from '../../../components/Loader.svelte';
  import { setBaseUrl } from '../../../modules/axios';

  export let userId;

  let title = $_('onboarding.almost_done');
  let subtitle = $_('onboarding.last_step');
  let loading = true;

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  onMount(async () => {
    await requestAccountValidationEmail(userId);
    loading = false;
  });

  const handleResendEmail = async () => {
    await requestAccountValidationEmail(userId);
  };
</script>

<svelte:head>
  <title>{$_('onboarding.title')}</title>
</svelte:head>

<OnboardingContainer step="5" {title} {subtitle}>
  <div slot="icon" class="w-11/12">
    <IconSatellites />
  </div>

  <section slot="content" class="w-full h-full md:flex justify-center">
    {#if loading}
      <Loader />
    {:else}
      <div class="md:w-3/4 my-8">
        <p class="my-4 whitespace-pre-line">
          {$_('onboarding.validation_mail_sent')}
        </p>
      </div>
    {/if}
  </section>

  <div class="flex w-1/2 m-auto" slot="button">
    {#if !loading}
      <Button on:click={handleResendEmail}>
        {$_('onboarding.resend_validation_email')}
      </Button>
    {/if}
  </div>
</OnboardingContainer>
