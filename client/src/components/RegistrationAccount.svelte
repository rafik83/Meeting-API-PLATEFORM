<script>
  import { _ } from 'svelte-i18n';

  import FormInput from './FormInput.svelte';
  import FormSelect from './FormSelect.svelte';
  import H4 from './H4.svelte';

  export let errorMessage;

  export let jobPositions;

  export let languages = [
    {
      code: 'fr',
      name: 'Français',
    },
    {
      code: 'nl',
      name: 'Néerlandais',
    },
  ];

  export let countries;

  export let timezones;

  export let validationErrors = {
    jobTitle: '',
    jobPosition: '',
    languages: '',
    timezone: '',
    country: '',
  };

  let formValues = {
    jobPosition: {},
    jobTitle: '',
    selectedMainLanguage: {},
    selectedSecondLanguage: {},
    selectedThirdLanguage: {},
    selectedCountry: {},
    selectedTimezone: {},
  };

  export let personalData;

  $: personalData = {
    jobPosition: formValues.jobPosition.id,
    languages: [
      formValues.selectedMainLanguage.code,
      formValues.selectedSecondLanguage.code,
      formValues.selectedThirdLanguage.code,
    ].filter((item) => item),
    jobTitle: formValues.jobTitle,
    country: formValues.selectedCountry.code,
    timezone: formValues.selectedTimezone.code,
  };
</script>

<form class="w-full">
  <H4 community withBackground>{$_('account.your_job')}</H4>
  <FormSelect
    options={jobPositions}
    name="jobPosition"
    label={$_('account.employment')}
    id="jobPosition"
    searchBar
    errorMessage={validationErrors.jobPosition}
    bind:selectedOption={formValues.jobPosition}
  />

  <FormInput
    name="jobTitle"
    type="text"
    label={$_('account.jobTitle')}
    displayLabel={$_('account.jobTitle')}
    bind:value={formValues.jobTitle}
    errorMessage={validationErrors.jobTitle}
  />

  <H4 community withBackground>
    {$_('account.you_speak')}
    <span class="text-xs font-semibold italic">
      ({$_('account.order_of_priority')})
    </span>
  </H4>

  {#if validationErrors.languages}
    <p class="text-error">{$_('validation.one_language_required')}</p>
  {/if}
  <FormSelect
    options={languages}
    name="main language"
    label={$_('account.main_language')}
    id="mainLanguage"
    searchBar
    {errorMessage}
    bind:selectedOption={formValues.selectedMainLanguage}
  />

  <FormSelect
    options={languages}
    name="second language"
    label={$_('account.second_language')}
    id="secondLanguage"
    searchBar
    bind:selectedOption={formValues.selectedSecondLanguage}
  />

  <FormSelect
    options={languages}
    name={'third language'}
    label={$_('account.third_language')}
    id="thirdLanguage"
    searchBar
    bind:selectedOption={formValues.selectedThirdLanguage}
  />

  <H4 community withBackground>{$_('account.your_location')}</H4>
  <FormSelect
    options={countries}
    name={'country'}
    label={$_('registration.country')}
    id="country"
    searchBar
    errorMessage={validationErrors.country}
    bind:selectedOption={formValues.selectedCountry}
  />

  <FormSelect
    options={timezones}
    name="timezone"
    label={$_('account.timezone')}
    id="timezone"
    searchBar
    errorMessage={validationErrors.timezone}
    bind:selectedOption={formValues.selectedTimezone}
  />
</form>
