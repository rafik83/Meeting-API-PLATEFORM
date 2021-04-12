<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Tag from './Tag.svelte';
</script>

<Meta
  title="Vimeet365/Tag"
  component={Tag}
  argTypes={{
    highlight: { control: 'boolean' },
  }}
/>

<Template let:args>
  <Tag {...args} />
</Template>

<Story
  name="Normal"
  args={{
    highlight: false,
  }}
/>

<Story
  name="Goal"
  args={{
    highlight: true,
  }}
/>
