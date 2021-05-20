<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Search from './Search.svelte';

  const handleSelectInput = (e) => {
    console.log('COMPANY_STORY', e.detail);
  };

  const searchResults = [
    {
      id: 1,
      name: 'hello',
    },
    {
      name: 'world',
    },
  ];
</script>

<Meta title="Vimeet365/Search" component={Search} />

<Template let:args>
  <Search
    {...args}
    on:item_selected={handleSelectInput}
    label="Rechercher"
    options={searchResults}
  />
</Template>

<Story name="basic" />
