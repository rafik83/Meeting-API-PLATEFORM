<script context="module">
  import { createMember } from '../../repository/member';
  import { register, findById, authenticate } from '../../repository/account';

  export async function preload({ query }, { communityId, userId }) {
    let countryList = [];

    let errorMessage = '';
    let user;
    const target = query.target;

    if (userId) {
      user = await findById(userId);
    }

    return {
      user,
      countryList,
      target,
      errorMessage,
      communityId,
    };
  }
</script>

<script>
  import { goto, stores } from '@sapper/app';
  import { getContext } from 'svelte';
  import { _ } from 'svelte-i18n';
  import Cookies from 'js-cookie';

  import LoginForm from '../../components/LoginForm.svelte';
  import RegistrationForm from '../../components/RegistrationForm.svelte';

  import { toOnboardingStep, toRegistrationStep } from '../../modules/routing';

  const { open, close } = getContext('simple-modal');

  const { session } = stores();

  export let target;
  export let user;
  export let errorMessage;
  export let communityId;

  import registrationSteps from '../../constants';

  const handleSignIn = async (values) => {
    try {
      $session.userId = await authenticate(values);
      await createMember(communityId);
      Cookies.set('userId', $session.userId, {
        expires: 365,
      });

      close();
      await goto(toOnboardingStep(1));
    } catch (e) {
      errorMessage = $_('messages.error_has_occured');
    }
  };

  const handleSignUp = async (values) => {
    try {
      $session.userId = (await register(values)).id;
      await goto(toRegistrationStep(registrationSteps.SIGN_IN));
    } catch (e) {
      if (e.response.status === 422) {
        errorMessage = $_('registration.user_already_exists');
      } else {
        errorMessage = $_('messages.error_has_occured');
      }
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

  $: switch (target) {
    case registrationSteps.SIGN_IN:
      open(
        LoginForm,
        {
          onSubmitForm: handleSignIn,
          errorMessage,
          signUpUrl: toRegistrationStep(registrationSteps.SIGN_UP),
        },
        modalOptions
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
        modalOptions
      );
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
