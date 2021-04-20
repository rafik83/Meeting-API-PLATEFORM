<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import VimeetCommunityLogo from './VimeetCommunityLogo.svelte';
</script>

<Meta title="Vimeet365/VimeetCommunityLogo" component={VimeetCommunityLogo} />

<Template let:args>
  <VimeetCommunityLogo {...args} />
</Template>

<Story
  name="Space"
  args={{
    communityName: 'Space',
  }}
/>

<Story
  name="Industry"
  args={{
    communityName: 'Industry',
  }}
/>
