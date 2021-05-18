<script>
  import { _ } from 'svelte-i18n';

  import FormInput from './FormInput.svelte';
  import FormTextarea from './FormTextarea.svelte';
  import FormSelect from './FormSelect.svelte';

  export let max;
  export let errors;
  export let selectOptions;
  export let company = {
    name: '',
    countryCode: '',
    website: '',
    activity: '',
  };

  let seletecdOption = {
    name: '',
    code: '',
  };

  $: company = {
    ...company,
    countryCode: seletecdOption.code,
  };

  const handleInput = (e) => {
    errors = {
      ...errors,
      [e.target.name]: '',
    };
  };
</script>

<form class="w-full">
  <FormInput
    type="text"
    label={$_('registration.company_name')}
    name="name"
    errorMessage={errors.name}
    bind:value={company.name}
    on:input={handleInput}
  />
  <FormSelect
    options={selectOptions}
    id="countryCode"
    name="countryCode"
    value=""
    searchBar
    label={$_('registration.country')}
    errorMessage={errors.countryCode}
    bind:selectedOption={seletecdOption}
    on:input={handleInput}
    on:blur={handleInput}
  />
  <FormInput
    type="text"
    label={$_('registration.website')}
    name="website"
    errorMessage={errors.website}
    bind:value={company.website}
    on:input={handleInput}
  />
  <FormTextarea
    {max}
    label={$_('registration.description')}
    name="activity"
    errorMessage={errors.activity}
    bind:value={company.activity}
    on:input={handleInput}
  />
</form>
