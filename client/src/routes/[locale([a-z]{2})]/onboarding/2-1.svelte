<script context="module">
  import { findById, updateUserCompany } from '../../../repository/account';
  import { toHomePage, toOnboardingStep } from '../../../modules/routing';
  import { getDomainFromEmail } from '../../../modules/email';
  import {
    getHubspotCompanies,
    createCompany,
  } from '../../../repository/company';

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
        let errorMessage;
        _.subscribe((format) => {
          errorMessage = format('messages.error_has_occured');
        });
        this.error(error.response.status, errorMessage);
      }
    }

    return {
      user,
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';
  import { goto, stores } from '@sapper/app';
  import { setBaseUrl } from '../../../modules/axios';
  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import IconLaunching from '../../../ui-kit/icons/IconLaunching/IconLaunching.svelte';
  import Button from '../../../components/Button.svelte';
  import CompanySelector from '../../../components/CompanySelector.svelte';
  import Loader from '../../../components/Loader.svelte';
  import { selectedCompanyStore } from '../../../stores/companyStore';
  import { isCompanyValid } from '../../../modules/validator';
  import { onMount } from 'svelte';

  export let user;

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  let loading = true;
  let companies;
  onMount(async () => {
    try {
      companies = await getHubspotCompanies(getDomainFromEmail(user.email));
      // If no companies has been found, we redirect the user to company creation page
      if (!companies || companies.length === 0) {
        await goto(toOnboardingStep('2-2'));
      }
    } catch (error) {
      // There may have been a problem with Hubspot
      if (error.response && error.response.status === 401) {
        await goto(toOnboardingStep('2-2'));
      }
    }

    loading = false;
  });

  const createNewCompany = async () => {
    selectedCompanyStore.resetCompanyData();
    await goto(toOnboardingStep('2-2'));
  };

  let selectedCompany;
  const handleCompanyData = async () => {
    try {
      if (!selectedCompany) {
        return;
      }
      const validationErrors = await isCompanyValid(selectedCompany);
      selectedCompanyStore.updateCompanyData(selectedCompany);
      if (validationErrors) {
        // if there are validation errors that means the comany was not fullyfilled
        // So we redirect the user to company form page so that he can complete the company information
        selectedCompanyStore.updateStatus(false);
        await goto(toOnboardingStep('2-2'));
      } else {
        let companyId = selectedCompany.id;
        if (!selectedCompany.id) {
          const { company } = await createCompany(
            { ...selectedCompany },
            user.id
          );
          companyId = company.id;
        }

        await updateUserCompany(user.id, companyId);
        await goto(toOnboardingStep('3'));
      }
    } catch (error) {
      console.log(error);
    }
  };
</script>

<svelte:head>
  <title>{$_('onboarding.title')}</title>
</svelte:head>

<OnboardingContainer step="2" {user}>
  <div slot="icon" class="w-10/12">
    <IconLaunching width="90%" class="mx-auto" />
  </div>

  <section slot="content" class="w-full h-full">
    {#if loading}
      <div class="mt-16">
        <Loader
          title={$_('messages.searching')}
          message={$_('registration.add_your_company_logo')}
        />
      </div>
    {:else}
      <CompanySelector
        on:create_company={createNewCompany}
        bind:selectedCompany
        {companies}
      />
    {/if}
  </section>

  <div class="flex justify-between w-1/2 m-auto" slot="button">
    <Button withMargin on:click={async () => await goto(toOnboardingStep('1'))}>
      {$_('messages.previous')}
    </Button>
    <Button on:click={handleCompanyData}>
      {$_('messages.next')}
    </Button>
  </div>
</OnboardingContainer>
