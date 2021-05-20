<script>
  import { _ } from 'svelte-i18n';

  import FormInput from './FormInput.svelte';
  import FormTextarea from './FormTextarea.svelte';
  import FormSelect from './FormSelect.svelte';
  import Search from './Search.svelte';

  export let max;
  export let errors;
  export let companiesOptions = [];
  export let countryOptions = [];
  export let loading = false;

  export let company = {
    name: '',
    countryCode: '',
    country: '',
    website: '',
    activity: '',
  };

  let selectedCountryOption = {
    name: '',
    code: '',
  };

  const getCompanyCountryCode = (selectedCompany) => {
    if (selectedCompany.countryCode) {
      return company.countryCode;
    }

    if (selectedCountryOption.code) {
      return selectedCountryOption;
    }
    return countryOptions.find((item) => {
      return item.name == selectedCompany.country;
    });
  };

  const handleSelectCompany = (e) => {
    const selectedCompany = e.detail;

    const countryCode = getCompanyCountryCode(selectedCompany);

    selectedCountryOption = {
      name: selectedCompany.country,
      code: selectedCompany.countryCode,
    };

    company = {
      ...selectedCompany,
    };

    if (!selectedCompany.countryCode && countryCode) {
      company = {
        ...selectedCompany,
        countryCode: countryCode.code,
      };

      selectedCountryOption = {
        name: selectedCompany.country,
        code: countryCode.code,
      };
    }

    if (!selectedCompany.activity) {
      company = {
        ...selectedCompany,
        activity: '',
      };
    }
  };

  $: if (selectedCountryOption.code) {
    company = {
      ...company,
      country: selectedCountryOption.name,
      countryCode: selectedCountryOption.code,
    };
  }

  const handleInput = (e) => {
    errors = {
      ...errors,
      [e.target.name]: '',
    };
  };
</script>

<form class="w-full">
  <Search
    {loading}
    label={$_('registration.company_name')}
    name="name"
    options={companiesOptions}
    errorMessage={errors.name}
    bind:value={company.name}
    on:input={handleInput}
    on:blur={handleInput}
    on:item_selected={handleSelectCompany}
  />
  <FormSelect
    options={countryOptions}
    name="countryCode"
    searchBar
    label={$_('registration.country')}
    bind:selectedOption={selectedCountryOption}
    errorMessage={errors.countryCode}
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
    on:blur={handleInput}
  />
  <FormTextarea
    {max}
    label={$_('registration.description')}
    name="activity"
    errorMessage={errors.activity}
    bind:value={company.activity}
    on:input={handleInput}
    on:blur={handleInput}
  />
</form>
