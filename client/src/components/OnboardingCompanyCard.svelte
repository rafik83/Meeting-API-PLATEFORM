<script>
  import { _ } from 'svelte-i18n';
  import H3 from './H3.svelte';
  import CompanyPicture from './CompanyPicture.svelte';
  import Button from './Button.svelte';
  import { sizes } from '../constants';

  export let company;
  export let isSelected = false;

  const { name, website, logo, hubspotId, country } = company;
</script>

<div
  class="flex flex-col justify-center items-center text-center w-94 h-72 p-5 m-2 shadow-lg rounded-2xl border {isSelected
    ? 'border-community-300'
    : 'border-gray-200'}"
>
  {#if logo}
    <CompanyPicture source={logo} companyWebsite={website} {name} />
  {/if}
  <H3>{name}</H3>
  {#if country}
    <p>{country}</p>
  {/if}
  <a target="_blank" href={website} class="text-community-100 underline"
    >{website}</a
  >
  <div class="w-44">
    {#if isSelected}
      <Button
        id={`company-${hubspotId}-button-selected`}
        on:click
        kind="community"
        size={sizes.SMALL}>{$_('registration.my_company')}</Button
      >
    {:else}
      <Button
        id={`company-${hubspotId}-button`}
        on:click
        kind="simple"
        size={sizes.SMALL}>{$_('registration.select')}</Button
      >
    {/if}
  </div>
</div>
