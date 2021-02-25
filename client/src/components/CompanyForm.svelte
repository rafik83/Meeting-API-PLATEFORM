<script>
  import { _ } from 'svelte-i18n';

  import FormInput from './FormInput.svelte';
  import FormTextarea from './FormTextarea.svelte';
  import FormSelect from './FormSelect.svelte';

  export let max;
  export let errors;

  export let selectOptions;

  let seletecdOption = {
    name: '',
    code: '',
  };

  export let company = {
    name: '',
    countryCode: '',
    website: '',
    activity: '',
  };

  $: company = {
    ...company,
    countryCode: seletecdOption.code,
  };
</script>

<form class="w-full">
  <FormInput
    type="text"
    label={$_('registration.company_name')}
    name="name"
    errorMessage={errors.name}
    bind:value={company.name}
  />
  <FormSelect
    options={selectOptions}
    name="countryCode"
    value=""
    searchBar
    label={$_('registration.country')}
    bind:selectedOption={seletecdOption}
    errorMessage={errors.countryCode}
  />
  <FormInput
    type="text"
    label={$_('registration.website')}
    name="website"
    errorMessage={errors.website}
    bind:value={company.website}
  />
  <FormTextarea
    {max}
    label={$_('registration.description')}
    name="activity"
    errorMessage={errors.activity}
    bind:value={company.activity}
  />
</form>
