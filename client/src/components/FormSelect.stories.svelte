<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import FormSelect from './FormSelect.svelte';

  const defaultProps = {
    options: [
      { code: 'en', name: 'Royaume-uni' },
      { code: 'fr', name: 'France' },
      { code: 'ru', name: 'Russie' },
      { code: 'be', name: 'Belgique' },
      { code: 'mc', name: 'Monaco' },
      { code: 'mn', name: 'Mongolia' },
      { code: 'me', name: 'Montenegro' },
    ],
    name: 'countries',
    label: 'Pays',
    id: 'coutries',
  };
</script>

<Meta title="Vimeet365/FormSelect" args={defaultProps} component={FormSelect} />

<Template let:args>
  <FormSelect {...args} />
</Template>

<Story name="Nomral" />
<Story name="SearchBar" args={{ ...defaultProps, searchBar: true }} />
