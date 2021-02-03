<script>
  import { _ } from 'svelte-i18n';

  import { createEventDispatcher } from 'svelte';
  import FormInput from './FormInput.svelte';
  import CheckBox from './CheckBox.svelte';
  import * as yup from 'yup';
  import { extractErrors } from '../modules/validator';

  const dispatch = createEventDispatcher();

  let values = {
    password: '',
    username: '',
  };
  let errors = {};

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
      dispatch('submitform', values);
    }
  };
</script>

<form class="mt-2">
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
    {$_('registration.log')}
  </button>
</form>
