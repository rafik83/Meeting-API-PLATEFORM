<script>
  import { _ } from 'svelte-i18n';

  import FormInput from './FormInput.svelte';
  import FormTextarea from './FormTextarea.svelte';
  import FormSelect from './FormSelect.svelte';

  // Mocked values
  export let max = 30;
  export let options = [
    { id: 'en', name: 'Royaume-uni' },
    { id: 'fr', name: 'France' },
  ];

  // Return values
  export let compagnyName;
  export let compagnyWebsite;
  export let compagnyDescription;
  export let selectedLocale;

  const handleLocale = (e) => {
    selectedLocale = e.target.value;
  };
</script>

<div class="w-full">
  <FormInput
    type="text"
    label={$_('registration.compagny_name')}
    name="compagnyName"
    bind:value={compagnyName}
  />
  <FormSelect
    {options}
    optionsTitle={$_('registration.country')}
    on:change={handleLocale}
  />
  <FormInput
    type="text"
    label={$_('registration.website')}
    name="website"
    bind:value={compagnyWebsite}
  />
  <FormTextarea
    bind:value={compagnyDescription}
    {max}
    name="description"
    label={$_('registration.description')}
  />
</div>
