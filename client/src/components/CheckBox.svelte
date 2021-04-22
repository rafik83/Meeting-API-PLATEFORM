<script>
  import {
    IconCheckBoxChecked,
    IconCheckBoxEmpty,
  } from '../ui-kit/icons/IconCheckBox';

  export let label;
  export let labelClass;
  export let checked;
  export let id = btoa(label);
</script>

<label id={`${id}-label`} class="text-community-200 flex items-start" for={id}>
  <span class="inline-block form-checkbox mr-2">
    <input {id} type="checkbox" bind:checked on:change class="hidden" />
    {#if checked}
      <IconCheckBoxChecked width="25" height="25" />
    {:else}
      <IconCheckBoxEmpty width="25" height="25" />
    {/if}
  </span>

  <span class={labelClass}>{label}</span>
</label>
