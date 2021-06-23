<script context="module">
  import { findById } from '../../../repository/account';
  import { toHomePage } from '../../../modules/routing';

  export async function preload(page, { userId, isAuthenticated }) {
    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }

    let user;

    try {
      user = await findById(userId);
    } catch (error) {
      if (error.response && error.response.status > 201) {
        console.error(error);
        this.error(error.response.status);
      }
    }

    return {
      user,
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';

  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import IconSatellite from '../../../ui-kit/icons/IconSatellite/IconSatellite.svelte';
  import { goto, stores } from '@sapper/app';
  import { setBaseUrl } from '../../../modules/axios';
  import Loader from '../../../components/Loader.svelte';
  import Button from '../../../components/Button.svelte';
  import { capitalize } from '../../../modules/textUtils';

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  export let user;
  let isLoading = false;
  const title = $_('onboarding.welcome_aboard');
  const subtitle = capitalize(`${user.firstName} ${user.lastName}`);
  const sideTitle = $_('onboarding.finish');
</script>

<svelte:head>
  <title>{$_('onboarding.title')}</title>
</svelte:head>

{#if isLoading}
  <Loader />
{:else}
  <OnboardingContainer {sideTitle} {title} {subtitle}>
    <div slot="icon" class="w-10/12">
      <IconSatellite width="90%" class="mx-auto" />
    </div>

    <section
      slot="content"
      class="w-full h-full flex items-center content-center md:flex justify-center"
    >
      <p class="w-1/2  text-center font-semibold text-3xl text-community-200">
        {$_('onboarding.congrats')}
      </p>
    </section>

    <div class="flex  justify-between w-1/2 m-auto" slot="button">
      <Button on:click={async () => await goto(toHomePage())}>
        {$_('messages.back_to_home')}
      </Button>
    </div>
  </OnboardingContainer>
{/if}
