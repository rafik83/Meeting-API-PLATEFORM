<script>
  import { _ } from 'svelte-i18n';

  import FormInput from './FormInput.svelte';
  import CheckBox from './CheckBox.svelte';
  import * as yup from 'yup';
  import { extractErrors } from '../modules/validator';
  import Separator from './Separator.svelte';
  import CreateAccountOrLoginLink from './CreateAccountOrLoginLink.svelte';
  import RegistrationFormHeader from './RegistrationFormHeader.svelte';

  let values = {
    password: '',
    username: '',
  };
  let errors = {};

  export let onSubmitForm;
  export let errorMessage;
  export let signUpUrl;

  let hasErrors = false;

  const validationSchema = yup.object().shape({
    username: yup.string().required($_('validation.field_required')),
    password: yup.string().required($_('validation.field_required')),
    rememberMe: yup.boolean(),
  });

  const handleSubmitForm = async () => {
    try {
      hasErrors = false;
      await validationSchema.validate(values, { abortEarly: false });
      errors = {};
    } catch (err) {
      hasErrors = true;
      errors = extractErrors(err);
    }

    if (!hasErrors) {
      onSubmitForm(values);
    }
  };
</script>

<div class="w-3/5 mx-auto my-5 flex-col items-center">
  <RegistrationFormHeader
    title={$_('registration.title')}
    subtitle={$_('registration.sign_in')}
  />

  {#if errorMessage}
    <p class="text-error">{errorMessage}</p>
  {/if}

  <div class="flex flex-col items-center">
    <form class="mt-2 w-full">
      <FormInput
        errorMessage={errors.username}
        type={'text'}
        label={$_('registration.loginOrEmail')}
        name="loginUserName"
        bind:value={values.username}
      />

      <FormInput
        errorMessage={errors.password}
        type={'password'}
        label={$_('registration.password')}
        name="loginPassword"
        bind:value={values.password}
      />

      <CheckBox
        on:checked={values.rememberMe}
        label={$_('registration.remember_me')}
      />
      <button
        on:click|preventDefault={handleSubmitForm}
        type="submit"
        class="w-full text-sm text-gray-50 font-semi-bold my-5 rounded-lg h-12  bg-gray-400">
        {$_('registration.sign_in')}
      </button>
    </form>

    <Separator text={$_('registration.or')} />

    <CreateAccountOrLoginLink
      content={$_('registration.sign_up')}
      label={$_('registration.no_account')}
      href={signUpUrl}
    />
  </div>
</div>
