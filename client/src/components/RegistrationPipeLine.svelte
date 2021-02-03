<script>
  import successkid from 'images/successkid.jpg';
  import { getContext } from 'svelte';
  import registrationSteps from '../constants';
  import LoginForm from './LoginForm.svelte';
  import RegistrationForm from './RegistrationForm.svelte';
  const { open, close } = getContext('simple-modal');

  export let onSignIn;
  export let onSignUp;
  export let errorMessage;
  export let navigateToRegistrationStep;
  export let user;

  const modalOptions = {
    styleCloseButton: {
      color: '#2A2E43',
      boxShadow: 'none',
    },
    styleWindow: {},
  };

  const handleSignIn = async (values) => {
    await onSignIn(values);

    if (!errorMessage) {
      close();
    }
  };

  export let step;

  $: switch (step) {
    case registrationSteps.SIGN_IN:
      open(
        LoginForm,
        {
          onSubmitForm: handleSignIn,
          errorMessage,
        },
        modalOptions
      );

      break;

    case registrationSteps.SIGN_UP:
      open(
        RegistrationForm,
        {
          onSubmitForm: onSignUp,
          errorMessage,
        },
        modalOptions
      );
      break;

    default:
      break;
  }

  const handleOpenModal = async () => {
    await navigateToRegistrationStep();
  };
</script>

<h1>This is a dummy page</h1>

{#if user}
  <h1>Vous êtes connecté</h1>
{:else}
  <p>Click on the success kid to start</p>
  <div id="success-kid" class="w-1/3 cursor-pointer" on:click={handleOpenModal}>
    <img class="w-full" alt="Success Kid" src={successkid} />
  </div>
{/if}
