<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import { buildFakeTag } from '../__fixtures__/FakeTags';
  import { buildFakeTimeZone } from '../__fixtures__/FakeTimeZone';
  import { buildFakeUser } from '../__fixtures__/FakeUser';
  import RegistrationAccount from './RegistrationAccount.svelte';

  const defaultArgs = {
    user: buildFakeUser({}),
    jobPositions: [buildFakeTag('Minister'), buildFakeTag('Priest')],
    languages: [
      {
        code: 'fr',
        name: 'Français',
      },
      {
        code: 'nl',
        name: 'Néerlandais',
      },
    ],
    countries: [
      {
        code: 'fr',
        name: 'France',
      },
      {
        code: 'nl',
        name: 'Pays-Bas',
      },
    ],
    timezones: [
      buildFakeTimeZone('Madrid (Europe)'),
      buildFakeTimeZone('Pologne (Antartic)'),
    ],
  };
</script>

<Meta
  title="Vimeet365/RegistrationAccount"
  args={defaultArgs}
  component={RegistrationAccount}
  argTypes={{
    highlight: { control: 'boolean' },
  }}
/>

<Template let:args>
  <RegistrationAccount {...args} />
</Template>

<Story name="Normal" />
