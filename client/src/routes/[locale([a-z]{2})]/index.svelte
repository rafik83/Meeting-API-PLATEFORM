<script context="module">
  import { isValidRegistrationStep } from '../../modules/validator';

  import { createMember, updateMember } from '../../repository/member';

  export async function preload({ query }, { communityId, user }) {
    const currentStep = query.step;
    if (currentStep && !isValidRegistrationStep(currentStep)) {
      this.error(404, '');
    }

    let errorMessage = '';

    return {
      user,
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

  import { findById, register, authenticate } from '../../repository/account';
  import { toHomePage, toRegistrationStep } from '../../modules/routing';

  const { open, close } = getContext('simple-modal');

  const { session } = stores();

  export let step;
  let currentQualificationStep = null;
  export let user;
  export let errorMessage;
  export let communityId;

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
        await goto(toRegistrationStep(registrationSteps.QUALIFICATION));
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

  const modalOptions = {
    styleCloseButton: {
      color: '#2A2E43',
      boxShadow: 'none',
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
            user: $session.user,
          },
          modalOptions,
          callBacks
        );
      }

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
