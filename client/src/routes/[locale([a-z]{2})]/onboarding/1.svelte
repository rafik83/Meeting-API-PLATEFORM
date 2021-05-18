<script context="module">
  import { getCountries } from '../../../repository/countries';
  import { getTimeZones } from '../../../repository/timezones';
  import { getAllJobPositions } from '../../../repository/nomenclatures';
  import { toHomePage, toOnboardingStep } from '../../../modules/routing';
  import {
    findById,
    updateProfile,
    uploadAvatar,
  } from '../../../repository/account';

  export async function preload(page, { userId, isAuthenticated }) {
    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }

    let countries;
    let timezones;
    let jobPositions;
    let user;

    try {
      countries = await getCountries();
      timezones = await getTimeZones();
      jobPositions = await getAllJobPositions();
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
      timezones,
      jobPositions,
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';
  import * as yup from 'yup';
  import { goto, stores } from '@sapper/app';
  import { setBaseUrl } from '../../../modules/axios';

  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import IconRocket from '../../../ui-kit/icons/IconRocket/IconRocket.svelte';
  import Button from '../../../components/Button.svelte';
  import { extractErrors } from '../../../modules/validator';

  import RegistrationAccount from '../../../components/RegistrationAccount.svelte';
  import AvatarUploader from '../../../components/AvatarUploader.svelte';

  export let user;
  export let countries;
  export let timezones;
  export let jobPositions;

  let userAvatar;
  let personalData;
  let validationErrors;

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  const validationSchema = yup.object().shape({
    jobPosition: yup
      .string($_('validation.field_required'))
      .required($_('validation.field_required')),
    country: yup.string().required($_('validation.field_required')),
    timezone: yup.string().required($_('validation.field_required')),
    languages: yup.array().min(1, $_('validation.one_language_required')),
    jobTitle: yup.string().required($_('validation.field_required')),
  });

  const handleUploadPersonalData = async () => {
    try {
      await validationSchema.validate(personalData, { abortEarly: false });
      await updateProfile(user.id, personalData);

      if (userAvatar) {
        await uploadAvatar(userAvatar, user.id);
      }
      await goto(toOnboardingStep(2));
    } catch (error) {
      validationErrors = extractErrors(error);
    }
  };
</script>

<svelte:head>
  <title>{$_('onboarding.title')}</title>
</svelte:head>

<OnboardingContainer step="1" {user}>
  <div slot="icon" class="w-11/12">
    <IconRocket />
  </div>

  <div slot="content" class="md:flex justify-between md:pl-10 px-5">
    <div class="md:w-1/2  md:pr-10">
      <RegistrationAccount
        {jobPositions}
        {timezones}
        {validationErrors}
        {countries}
        bind:personalData
      />
    </div>

    <div class="md:w-1/2">
      <AvatarUploader
        bind:uploadedFile={userAvatar}
        fileMaxSize={1 * 1024 * 1024}
      />
    </div>
  </div>

  <div class="w-1/3 m-auto" slot="button">
    <Button on:click={handleUploadPersonalData}>
      {$_('messages.next')}
    </Button>
  </div>
</OnboardingContainer>
