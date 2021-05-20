<script>
  import { _ } from 'svelte-i18n';
  import OnboardingCompanyPlaceholder from './OnboardingCompanyPlaceholder.svelte';
  import OnboardingCompanyCard from './OnboardingCompanyCard.svelte';
  import H3 from './H3.svelte';
  import H4 from './H4.svelte';
  import IconCompany from '../ui-kit/icons/IconCompany/IconCompany.svelte';
  import { createEventDispatcher } from 'svelte';

  export let companies = [];
  export let selectedCompany = {};

  const dispatch = createEventDispatcher();

  const handleSelectCompany = (company) => {
    selectedCompany = company;
  };

  const handleCreateCompany = () => {
    dispatch('create_company');
  };
</script>

<div>
  <div class="w-full sm:pl-12">
    <div class="pl-5 sm:pl-0">
      {#if selectedCompany.name}
        <H3>{$_('registration.your_company_is')}</H3>
        <div class="h-14 w-full">
          <H4 withBackground community inlineBlock>
            <span class="flex items-center h-7">
              <IconCompany width="16" />
              <span class="ml-2">
                {selectedCompany.name}
              </span>
            </span>
          </H4>
        </div>
      {/if}
    </div>
    <div class="w-full mb-5 flex flex-col items-center justify-center">
      <p>
        {$_('registration.we_fond_results', {
          values: { n: companies.length },
        })}
      </p>
      <H3>{$_('registration.select_company')}</H3>
    </div>
    <div
      class="overflow-y-auto w-full flex items-center justify-center flex-wrap"
    >
      {#each companies as company}
        <OnboardingCompanyCard
          on:click={() => handleSelectCompany(company)}
          {company}
          isSelected={selectedCompany.hubspotId === company.hubspotId}
        />
      {/each}
      <OnboardingCompanyPlaceholder on:click={() => handleCreateCompany({})} />
    </div>
  </div>
</div>
