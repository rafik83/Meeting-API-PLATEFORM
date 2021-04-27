<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import Button from './Button.svelte';
  import { sizes } from './constants';
  import SlideLabel from './SlideLabel.svelte';
</script>

<Meta title="Vimeet365/SlideLabel" component={SlideLabel} />

<Template let:args>
  <SlideLabel {...args}>
    <div class="text-gray-50">
      <h1 class="font-black text-xl">Hello world</h1>
      <p>Some text inside</p>
      <Button kind="tiertiary" arrow size={sizes.SMALL} fullWidth={false}
        >Click here</Button
      >
    </div>
  </SlideLabel>
</Template>

<Story name="Basic" />
