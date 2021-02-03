<script context="module">
  import { isValidRegistrationStep } from '../../modules/validator';
  import registrationSteps from '../../constants';

  export async function preload({ query }, session) {
    const currentStep = session.user ? registrationSteps.SIGN_IN : query.step;
    if (currentStep && !isValidRegistrationStep(currentStep)) {
      this.error(404, '');
    }
    return { user: session.user, step: currentStep };
  }
</script>

<script>
  import Modal from 'svelte-simple-modal';
  import RegistrationPipleLine from '../../components/RegistrationPipeLine.svelte';
  import { findById, register, authenticate } from '../../repository/account';
  import { goto, stores } from '@sapper/app';
  import { _ } from 'svelte-i18n';
  import { toHomePage, toRegistrationStep } from '../../modules/routing';

  const { session } = stores();

  export let step;
  export let user;
  let errorMessage;

  const handleNavigateToRegistrationStep = async () => {
    await goto(toRegistrationStep(registrationSteps.SIGN_IN));
  };

  const handleSignIn = async (values) => {
    try {
      const userId = await authenticate(values);
      $session.user = await findById(userId);
      await goto(toHomePage());
    } catch (e) {
      errorMessage = $_('messages.error_has_occured');
    }
  };

  const handleSignUp = async (values) => {
    try {
      $session.user = await register(values);
    } catch (e) {
      errorMessage = $_('messages.error_has_occured');
    }
  };
</script>

<Modal>
  <RegistrationPipleLine
    {user}
    navigateToRegistrationStep={handleNavigateToRegistrationStep}
    {step}
    onSignIn={handleSignIn}
    onSignUp={handleSignUp}
    {errorMessage}
  />
</Modal>
