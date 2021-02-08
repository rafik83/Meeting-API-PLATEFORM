<script>
  import { _ } from 'svelte-i18n';

  import FormInput from './FormInput.svelte';
  import TermsAndConditions from './TermsAndConditions.svelte';
  import * as yup from 'yup';
  import { extractErrors } from '../modules/validator';
  import Separator from './Separator.svelte';
  import { toRegistrationStep } from '../modules/routing';
  import registrationSteps from '../constants';
  import CreateAccountOrLoginLink from './CreateAccountOrLoginLink.svelte';
  import RegistrationPipelineHeader from './RegistrationPipelineHeader.svelte';

  export let errorMessage;

  let values = {
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    acceptedTermsAndCondition: false,
  };

  let errors = {};
  export let onSubmitForm;

  let hasErrors = false;

  const validationSchema = yup.object().shape({
    firstName: yup.string().required($_('validation.field_required')),
    lastName: yup.string().required($_('validation.field_required')),
    email: yup
      .string()
      .email($_('validation.invalid_email'))
      .required($_('validation.field_required')),
    password: yup
      .string()
      .min(8, $_('validation.invalid_password', { values: { minPassword: 8 } }))
      .required($_('validation.field_required')),
    acceptedTermsAndCondition: yup
      .boolean()
      .oneOf([true], $_('validation.terms_and_conditions_not_selected'))
      .required($_('validation.terms_and_conditions_not_selected')),
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
  <RegistrationPipelineHeader
    title={$_('registration.title')}
    subtitle={$_('registration.title')}
  />

  {#if errorMessage}
    <p class="text-error">{errorMessage}</p>
  {/if}
  <div class="flex flex-col items-center">
    <form class="mt-2">
      <FormInput
        errorMessage={errors.firstName}
        type={'text'}
        label={$_('registration.firstname')}
        name="firstname"
        bind:value={values.firstName}
      />

      <FormInput
        errorMessage={errors.lastName}
        type={'text'}
        label={$_('registration.lastname')}
        name="lastname"
        bind:value={values.lastName}
      />

      <FormInput
        errorMessage={errors.email}
        type={'email'}
        label={$_('registration.email')}
        name="email"
        bind:value={values.email}
      />

      <FormInput
        errorMessage={errors.password}
        type={'password'}
        label={$_('registration.password')}
        name="password"
        bind:value={values.password}
      />

      <TermsAndConditions
        errorMessage={errors.acceptedTermsAndCondition}
        bind:checked={values.acceptedTermsAndCondition}
      />

      <button
        on:click|preventDefault={handleSubmitForm}
        type="submit"
        class="w-full text-sm text-gray-50 font-semi-bold my-5 rounded-lg h-12  bg-gray-400">
        {$_('registration.sign_up')}
      </button>
    </form>

    <Separator text={$_('registration.or')} />

    <CreateAccountOrLoginLink
      content={$_('registration.register')}
      label={$_('registration.no_account')}
      href={toRegistrationStep(registrationSteps.SIGN_IN)}
    />
  </div>
</div>
