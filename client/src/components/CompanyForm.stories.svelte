<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import CompanyForm from './CompanyForm.svelte';
  import { buildFakeCompany } from '../__fixtures__/FakeCompany';

  const countryOptions = [
    { code: 'en', name: 'Royaume-uni' },
    { code: 'fr', name: 'France' },
    { code: 'ru', name: 'Russie' },
    { code: 'be', name: 'Belgique' },
    { code: 'mc', name: 'Monaco' },
    { code: 'mn', name: 'Mongolia' },
    { code: 'me', name: 'Montenegro' },
  ];

  const companiesOptions = [
    buildFakeCompany({ name: 'tata' }),
    buildFakeCompany({ name: 'tato' }),
    buildFakeCompany({ name: 'tatu' }),
    buildFakeCompany({ name: 'tati' }),
  ];

  let companyData;

  const company = buildFakeCompany({ countryCode: 'fr' });
  const companyWithoutMatchingCode = buildFakeCompany({ countryCode: 'xxx' });
</script>

<Meta title="Vimeet365/CompanyForm" component={CompanyForm} />

<Template let:args>
  <CompanyForm
    {...args}
    max="30"
    {companiesOptions}
    {countryOptions}
    errors={{}}
    bind:company={companyData}
  />
</Template>

<Story name="Normal" />

<Story
  name="Error"
  errors={{
    name: 'fe',
    countryCode: 'fe',
    website: 'fe',
    activity: 'fe',
  }}
/>

<Story name="With prefilled values" args={{ company }} />
<Story
  name="With company without matching country code"
  args={{ company: companyWithoutMatchingCode }}
/>
