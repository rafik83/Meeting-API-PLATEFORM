<script context="module">
  import { getCountries } from '../../../repository/countries';
  import { findById, updateUserCompany } from '../../../repository/account';
  import { toHomePage, toOnboardingStep } from '../../../modules/routing';
  import {
    createCompany,
    uploadCompanyLogo,
  } from '../../../repository/company';

  export async function preload(page, { userId, isAuthenticated }) {
    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }
    let countries;
    let user;

    try {
      countries = await getCountries();
      user = await findById(userId);
    } catch (error) {
      if (error.response && error.response.status > 201) {
        console.error(error);
        this.error(error.response.status);
      }
    }

    return {
      user,
      countries,
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';
  import { goto, stores } from '@sapper/app';
  import { isCompanyValid } from '../../../modules/validator';
  import { setBaseUrl } from '../../../modules/axios';
  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import CompanyForm from '../../../components/CompanyForm.svelte';
  import FileUploader from '../../../components/FileUploader.svelte';
  import IconLaunching from '../../../ui-kit/icons/IconLaunching/IconLaunching.svelte';
  import Button from '../../../components/Button.svelte';
  import H3 from '../../../components/H3.svelte';
  import { debounce } from 'debounce';
  import { selectedCompanyStore } from '../../../stores/companyStore';
  import { getHubspotCompanies } from '../../../repository/company';

  export let user;
  export let countries;

  let loading = false;
  let errorMessage = '';

  let companyData = {
    name: '',
    countryCode: '',
    country: '',
    website: '',
    activity: '',
  };
  let companyLogo;
  let maxDescriptionLength = 3000;
  let validationErrors = {
    name: '',
    countryCode: '',
    website: '',
    activity: '',
  };

  let companiesOptions;
  const searchHubspotCompanies = async (companyName) => {
    loading = true;
    companiesOptions = await getHubspotCompanies(companyName);
    loading = false;
  };

  let previousCompanyName = '';

  const debouncedSearchHubpostCompanies = debounce(searchHubspotCompanies, 500);

  $: if (companyData.name !== previousCompanyName) {
    debouncedSearchHubpostCompanies(companyData.name);
    previousCompanyName = companyData.name;
  }

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  const translateErrors = (errors, options) => {
    return Object.keys(errors).reduce((prev, current) => {
      return {
        ...prev,
        [current]: $_(errors[current], options),
      };
    }, {});
  };

  if ($selectedCompanyStore.companyData) {
    companyData = $selectedCompanyStore.companyData;
  }

  const updateOrCreateCompany = async () => {
    try {
      const errors = await isCompanyValid(companyData);

      if (!errors) {
        let companyToUpdate;
        if ($selectedCompanyStore.isCreation || !companyData.id) {
          selectedCompanyStore.updateStatus(false);
          const { company } = await createCompany({ ...companyData }, user.id);
          companyToUpdate = company;
        } else {
          companyToUpdate = companyData;
        }

        await updateUserCompany(user.id, companyToUpdate.id);

        if (companyLogo) {
          await uploadCompanyLogo(companyLogo, companyToUpdate.id);
        }
        selectedCompanyStore.updateCompanyData(companyToUpdate);

        await goto(toOnboardingStep(3));
      } else {
        validationErrors = translateErrors(errors, {
          values: {
            value: 300,
          },
        });
      }
    } catch (error) {
      if (error.response && error.response.status > 201) {
        errorMessage = $_('messages.error_has_occured');
      }
    }
  };

  let pageTitle;
  if ($selectedCompanyStore.isCreation) {
    pageTitle = $_('validation.company_not_found');
  } else {
    pageTitle = $_('onboarding.please_update_company_data');
  }
</script>

<svelte:head>
  <title>{$_('onboarding.title')}</title>
</svelte:head>

<OnboardingContainer step="2" {user}>
  <div slot="icon" class="w-10/12">
    <IconLaunching width="90%" class="mx-auto" />
  </div>

  <section slot="content" class="w-full h-full pl-10">
    {#if errorMessage}
      <p class="text-error my-5">{errorMessage}</p>
    {/if}
    <div class="md:w-5/12">
      <H3>{pageTitle}.</H3>
    </div>
    <div class="md:flex justify-between flex-warp">
      <div class="md:w-5/12">
        <CompanyForm
          {loading}
          {companiesOptions}
          countryOptions={countries}
          max={maxDescriptionLength}
          errors={validationErrors}
          bind:company={companyData}
        />
      </div>

      <div class="md:w-5/12 mx-auto">
        <H3 community>{$_('registration.add_your_company_logo')}.</H3>
        <div class="md:h-3/6 mt-4">
          <FileUploader
            accept={['image/jpg', 'image/jpeg', 'image/png']}
            fileMaxSize={1 * 1024 * 1024}
            bind:uploadedFile={companyLogo}
          />
        </div>
      </div>
    </div>
  </section>

  <div class="flex justify-between w-1/2 m-auto" slot="button">
    <Button withMargin on:click={async () => await goto(toOnboardingStep('1'))}>
      {$_('messages.previous')}
    </Button>
    <Button on:click={updateOrCreateCompany}>
      {$_('messages.next')}
    </Button>
  </div>
</OnboardingContainer>
