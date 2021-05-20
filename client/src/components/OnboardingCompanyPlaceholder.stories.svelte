<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import OnboardingCompanyPlaceholder from './OnboardingCompanyPlaceholder.svelte';
</script>

<Meta
  title="Vimeet365/OnboardingCompanyPlaceholder"
  component={OnboardingCompanyPlaceholder}
/>

<Template let:args>
  <OnboardingCompanyPlaceholder {...args} />
</Template>

<Story name="Basic" />
