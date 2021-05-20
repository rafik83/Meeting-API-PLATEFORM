<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import OnboardingCompanyCard from './OnboardingCompanyCard.svelte';
  import { buildFakeCompany } from '../__fixtures__/FakeCompany.ts';
</script>

<Meta
  title="Vimeet365/OnboardingCompanyCard"
  component={OnboardingCompanyCard}
/>

<Template let:args>
  <OnboardingCompanyCard {...args} company={buildFakeCompany()} />
</Template>

<Story name="Basic" />
