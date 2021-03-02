<script context="module">
  import { isValidRegistrationStep } from '../../modules/validator';

  import { getCountries } from '../../repository/countries';
  import { createMember, updateMember } from '../../repository/member';

  export async function preload({ query }, { communityId, user }) {
    let countryList = [];

    let errorMessage = '';
    const currentStep = query.step;
    if (currentStep && !isValidRegistrationStep(currentStep)) {
      this.error(404, '');
    }

    if (currentStep === registrationSteps.COMPANY_REGISTRATION) {
      countryList = await getCountries();
    }

    return {
      user,
      countryList,
      step: currentStep,
      errorMessage,
      communityId,
    };
  }
</script>

<script>
  import { goto, stores } from '@sapper/app';
  import { getContext } from 'svelte';
  import { _ } from 'svelte-i18n';

  import LoginForm from '../../components/LoginForm.svelte';
  import RegistrationForm from '../../components/RegistrationForm.svelte';
  import TagSelector from '../../components/TagSelector.svelte';
  import RegistrationCompany from '../../components/RegistrationCompany.svelte';
  import AvatarUploader from '../../components/AvatarUploader.svelte';

  import {
    findById,
    register,
    authenticate,
    uploadAvatar,
  } from '../../repository/account';
  import { createCompany, uploadCompanyLogo } from '../../repository/company';

  import { toHomePage, toRegistrationStep } from '../../modules/routing';

  const { open, close } = getContext('simple-modal');

  const { session } = stores();

  export let step;
  let currentQualificationStep = null;
  export let user;
  export let errorMessage;
  export let communityId;
  export let countryList;

  let memberId = null;

  import registrationSteps from '../../constants';
  import { setTagPriorityToNullIfNotDefined } from '../../modules/tagManagement';

  const handleSignIn = async (values) => {
    try {
      const userId = await authenticate(values);
      $session.user = await findById(userId);
      const result = await createMember(communityId);

      memberId = result.id;
      currentQualificationStep = result.currentQualificationStep;

      if (
        currentQualificationStep &&
        Object.keys(currentQualificationStep).length > 0
      ) {
        await goto(toRegistrationStep(registrationSteps.UPLOAD_USER_AVATAR));
      } else {
        await goto(toHomePage());
        close();
      }
    } catch (e) {
      errorMessage = $_('messages.error_has_occured');
    }
  };

  const handleSignUp = async (values) => {
    try {
      $session.user = await register(values);
      await goto(toRegistrationStep(registrationSteps.SIGN_IN));
    } catch (e) {
      if (e.response.status === 422) {
        errorMessage = $_('registration.user_already_exists');
      } else {
        errorMessage = $_('messages.error_has_occured');
      }
    }
  };

  const handleNextQualificationStep = async (values) => {
    const valuesToSubmit = {
      step: currentQualificationStep.id,
      tags: values,
    };
    try {
      const result = await updateMember(memberId, valuesToSubmit);

      currentQualificationStep = result.currentQualificationStep;

      if (!currentQualificationStep) {
        await goto(toHomePage());
        close();
      }
    } catch (e) {
      errorMessage = $_('messages.error_has_occured');
    }
  };

  const handleUploadAvatar = async (accountAvatar) => {
    try {
      if (accountAvatar) {
        await uploadAvatar(accountAvatar, user.id);
        await goto(toRegistrationStep(registrationSteps.COMPANY_REGISTRATION));
      }
    } catch (error) {
      errorMessage = $_('messages.error_has_occured');
    }
  };

  const handleCreateCompany = async (companyLogo, companyData) => {
    try {
      const { company } = await createCompany(companyData, user.id);
      if (companyLogo) {
        await uploadCompanyLogo(companyLogo, company.id);
      }

      await goto(toRegistrationStep(registrationSteps.QUALIFICATION));
    } catch (error) {
      errorMessage = $_('messages.error_has_occured');
    }
  };

  const modalOptions = {
    styleCloseButton: {
      color: '#2A2E43',
      boxShadow: 'none',
    },
    styleWindow: {
      width: '30rem',
    },
  };

  const callBacks = {
    onClose: async () => {
      await goto(toHomePage());
    },
  };

  $: switch (step) {
    case registrationSteps.SIGN_IN:
      open(
        LoginForm,
        {
          onSubmitForm: handleSignIn,
          errorMessage,
          signUpUrl: toRegistrationStep(registrationSteps.SIGN_UP),
        },
        modalOptions,
        callBacks
      );

      break;

    case registrationSteps.SIGN_UP:
      open(
        RegistrationForm,
        {
          onSubmitForm: handleSignUp,
          errorMessage,
          signInUrl: toRegistrationStep(registrationSteps.SIGN_IN),
        },
        modalOptions,
        callBacks
      );
      break;

    case registrationSteps.QUALIFICATION:
      if (
        currentQualificationStep &&
        Object.keys(currentQualificationStep).length > 0
      ) {
        open(
          TagSelector,
          {
            onNext: handleNextQualificationStep,
            title: currentQualificationStep.title,
            min: currentQualificationStep.min,
            max: currentQualificationStep.max,
            nomenclatureTags: setTagPriorityToNullIfNotDefined(
              currentQualificationStep.nomenclature.tags
            ),
            errorMessage,
            user,
          },
          modalOptions,
          callBacks
        );
      }

      break;

    case registrationSteps.COMPANY_REGISTRATION:
      open(
        RegistrationCompany,
        { countryList, user, onCreateCompany: handleCreateCompany },
        modalOptions,
        callBacks
      );

      break;

    case registrationSteps.UPLOAD_USER_AVATAR:
      open(
        AvatarUploader,
        { user, onUploadAvatar: handleUploadAvatar },
        modalOptions,
        callBacks
      );

      break;

    default:
      break;
  }
</script>

{#if user}
  <h1>Vous êtes connecté</h1>
{:else}
  <button
    id="join-community"
    class="md:w-1/3 w-full font-semi-bold text-gray-50 bg-community-300 h-1/3 "
    on:click={() => goto(toRegistrationStep(registrationSteps.SIGN_IN))}>
    Click here to join the community
  </button>
{/if}
