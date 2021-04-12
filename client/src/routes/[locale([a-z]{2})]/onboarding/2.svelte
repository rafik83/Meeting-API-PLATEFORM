<script context="module">
  import { getCountries } from '../../../repository/countries';
  import { findById } from '../../../repository/account';
  import { toHomePage, toOnboardingStep } from '../../../modules/routing';
  import {
    createCompany,
    uploadCompanyLogo,
  } from '../../../repository/company';

  export async function preload(page, { userId, isAuthenticated }) {
    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }
    const countries = await getCountries();
    const user = await findById(userId);

    return {
      user,
      countries,
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';
  import * as yup from 'yup';
  import { goto, stores } from '@sapper/app';
  import { extractErrors } from '../../../modules/validator';
  import { setBaseUrl } from '../../../modules/axios';
  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import CompanyForm from '../../../components/CompanyForm.svelte';
  import FileUploader from '../../../components/FileUploader.svelte';
  import IconLaunching from '../../../ui-kit/icons/IconLaunching/IconLaunching.svelte';
  import Button from '../../../components/Button.svelte';
  import H3 from '../../../components/H3.svelte';

  export let user;
  export let countries;

  let companyData;
  let companyLogo;
  let maxDescriptionLength = 3000;
  let validationErrors = {
    name: '',
    countryCode: '',
    website: '',
    activity: '',
  };

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  const validationSchema = yup.object().shape({
    name: yup.string().required($_('validation.field_required')),
    countryCode: yup.string().required($_('validation.field_required')),
    website: yup
      .string()
      .url($_('validation.wrong_url'))
      .required($_('validation.field_required')),
    activity: yup
      .string()
      .max(
        maxDescriptionLength,
        $_('validation.maximum_characters', { value: maxDescriptionLength })
      ),
  });

  const handleUploadCompanyData = async () => {
    try {
      await validationSchema.validate(companyData, { abortEarly: false });
      const { company } = await createCompany(companyData, user.id);

      if (companyLogo) {
        await uploadCompanyLogo(companyLogo, company.id);
      }
      await goto(toOnboardingStep(3));
    } catch (error) {
      validationErrors = extractErrors(error);
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

  <section slot="content" class="w-full p-8 h-full">
    <div class="md:w-5/12">
      <H3>{$_('validation.company_not_found')}.</H3>
    </div>
    <div class="md:flex justify-between  flex-warp">
      <div class="md:w-5/12">
        <CompanyForm
          selectOptions={countries}
          max={maxDescriptionLength}
          errors={validationErrors}
          bind:company={companyData}
        />
      </div>

      <div class="md:w-5/12 mx-auto">
        <H3 community>{$_('registration.create_your_company')}.</H3>
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

  <div slot="button">
    <Button on:click={handleUploadCompanyData}>
      {$_('registration.next')}
    </Button>
  </div>
</OnboardingContainer>
