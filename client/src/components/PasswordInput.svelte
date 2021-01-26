<script>
  import FormInput from './FormInput.svelte';
  import IconEye from './IconEye.svelte';
  export let name;
  export let value = '';
  export let label = '';
  export const required = 'required';
  let displayPassword = false;

  const toggle = () => {
    displayPassword = !displayPassword;
  };
</script>

<FormInput
  type={displayPassword ? 'text' : 'password'}
  {required}
  {label}
  {name}
  bind:value
/>

<span on:click={toggle}><IconEye /></span>
