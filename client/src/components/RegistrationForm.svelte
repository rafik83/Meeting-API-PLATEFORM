<script>
  import { _ } from 'svelte-i18n';

  import { createEventDispatcher } from 'svelte';
  import TermsAndConditions from './TermsAndConditions.svelte';
  import FormInput from './FormInput.svelte';
  import PasswordInput from './PasswordInput.svelte';

  const dispatch = createEventDispatcher();

  let values = {};

  const handleCheckboxChange = (e) => {
    values = {
      ...values,
      termsAndConditionChecked: e.target.checked,
    };
  };

  const handleSubmitForm = () => {
    dispatch('submitform', values);
  };
</script>

<form class="mt-2">
  <FormInput
    type={'text'}
    label={$_('registration.lastname')}
    name={$_('registration.lastname')}
    bind:value={values.lastname}
  />
  <FormInput
    type={'text'}
    label={$_('registration.firstname')}
    name={$_('registration.firstname')}
    bind:value={values.firstname}
  />
  <FormInput
    type={'email'}
    label={$_('registration.email')}
    name={$_('registration.email')}
    bind:value={values.email}
  />

  <PasswordInput
    label={$_('registration.password')}
    name={$_('registration.password')}
    bind:value={values.password}
  />

  <div class="flex flex-row mt-4 mb-4 items-center">
    <TermsAndConditions
      on:change={handleCheckboxChange}
      name={$_('registration.conditions')}
    />
  </div>
  <button
    on:click|preventDefault={handleSubmitForm}
    type="submit"
    class="w-full font-semibold rounded-lg bg-gray-400 h-12 text-gray-50">
    {$_('registration.button')}
  </button>
</form>
