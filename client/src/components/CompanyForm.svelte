<script>
  import { _ } from 'svelte-i18n';

  import FormInput from './FormInput.svelte';
  import FormTextarea from './FormTextarea.svelte';
  import FormSelect from './FormSelect.svelte';

  // Input values
  export let max;
  export let options;
  export let errors;

  // Return values
  export let submittedValues = {
    compagnyName: '',
    selectedLocale: '',
    compagnyWebsite: '',
    compagnyDescription: '',
  };

  const handleLocale = (e) => {
    submittedValues.selectedLocale = e.target.value;
  };
</script>

<div class="w-full">
  <FormInput
    type="text"
    label={$_('registration.compagny_name')}
    name="compagnyName"
    errorMessage={errors.compagnyName}
    bind:value={submittedValues.compagnyName}
  />
  <FormSelect
    {options}
    optionsTitle={$_('registration.country')}
    on:change={handleLocale}
    errorMessage={errors.selectedLocale}
  />
  <FormInput
    type="text"
    label={$_('registration.website')}
    name="website"
    errorMessage={errors.compagnyWebsite}
    bind:value={submittedValues.compagnyWebsite}
  />
  <FormTextarea
    {max}
    label={$_('registration.description')}
    name="description"
    errorMessage={errors.compagnyDescription}
    bind:value={submittedValues.compagnyDescription}
  />
</div>
