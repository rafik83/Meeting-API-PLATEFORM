<script context="module">
  import { getCountries } from '../../../repository/countries';
  import { getTimeZones } from '../../../repository/timezones';
  import { getAllJobPositions } from '../../../repository/nomenclatures';
  import {
    findById,
    updateProfile,
    uploadAvatar,
  } from '../../../repository/account';

  export async function preload(page, session) {
    const countries = await getCountries();
    const timezones = await getTimeZones();
    const jobPositions = await getAllJobPositions();
    const user = await findById(session.userId);

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
  import { goto } from '@sapper/app';

  import RegistrationPipeLineHeader from '../../../components/RegistrationPipeLineHeader.svelte';
  import IconRocket from '../../../ui-kit/icons/IconRocket/IconRocket.svelte';
  import Button from '../../../components/Button.svelte';
  import { extractErrors } from '../../../modules/validator';
  import { toHomePage } from '../../../modules/routing';
  import RegistrationAccount from '../../../components/RegistrationAccount.svelte';
  import AvatarUploader from '../../../components/AvatarUploader.svelte';

  export let user;
  export let countries;
  export let timezones;
  export let jobPositions;

  let userAvatar;
  let personalData;
  let validationErrors;

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
      await goto(toHomePage());
    } catch (error) {
      validationErrors = extractErrors(error);
    }
  };
</script>

<svelte:head>
  <title>{$_('onboarding.title')}</title>
</svelte:head>

<div
  class="fixed xl:block hidden top-0 left-0 bottom-0 bg-gradient-to-tl
         from-community-300 to-gray-400 xl:w-1/3 content-center"
>
  <div class="h-full py-5 flex flex-col items-center justify-center">
    <IconRocket width="90%" />
    <p class="text-gray-50 text-2xl font-bold uppercase">Step 1/5</p>
  </div>
</div>

<section class="flex h-full w-full">
  <div
    class="xl:fixed top-0 right-0 bottom-24 overflow-auto xl:w-2/3 w-full p-5 "
  >
    <RegistrationPipeLineHeader
      title={`${$_('registration.hello')}.`}
      subtitle={`${user.firstName} ${user.lastName}`}
    />
    <div class=" flex justify-between">
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
  </div>
  <div class="fixed right-0 bottom-0 xl:w-2/3 w-full h-24 bg-gray-50 px-5">
    <Button on:click={handleUploadPersonalData}>
      {$_('registration.next')}
    </Button>
  </div>
</section>
