<script>
  import { _ } from 'svelte-i18n';

  import FormInput from './FormInput.svelte';
  import FormTextarea from './FormTextarea.svelte';
  import FormSelect from './FormSelect.svelte';

  // Input values
  export let max;
  export let selectOptions;
  export let errors;

  let seletecdOption = {
    name: '',
    code: '',
  };

  // Return values
  export let company = {
    compagnyName: '',
    selectedLocale: '',
    compagnyWebsite: '',
    compagnyDescription: '',
  };

  $: company = {
    ...company,
    selectedLocale: seletecdOption.code,
  };
</script>

<form class=" w-full">
  <FormInput
    type="text"
    label={$_('registration.compagny_name')}
    name="compagnyName"
    errorMessage={errors.compagnyName}
    bind:value={company.compagnyName}
  />
  <FormSelect
    options={selectOptions}
    name="countries-compagny"
    value=""
    searchBar
    label={$_('registration.country')}
    bind:selectedOption={seletecdOption}
    errorMessage={errors.selectedLocale}
  />
  <FormInput
    type="text"
    label={$_('registration.website')}
    name="website"
    errorMessage={errors.compagnyWebsite}
    bind:value={company.compagnyWebsite}
  />
  <FormTextarea
    {max}
    label={$_('registration.description')}
    name="description"
    errorMessage={errors.compagnyDescription}
    bind:value={company.compagnyDescription}
  />
</form>
