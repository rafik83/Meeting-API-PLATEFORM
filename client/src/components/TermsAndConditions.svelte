<script>
  import { _ } from 'svelte-i18n';

  export let name;
  export let isChecked = false;
</script>

<input
  on:change
  type="checkbox"
  class="form-checkbox h-6 w-10 mr-2"
  bind:checked={isChecked}
/>

<label for={name} class="block text-gray-400">
  {@html $_('registration.conditions', {
    values: {
      link:
        '<a href="http://example.fr" target="_blank">' +
        $_('registration.termsConditions') +
        '</a>',
      link2:
        '<a href="http://example2.fr" target="_blank">' +
        $_('registration.policyConditions') +
        '</a>',
    },
  })}
</label>
