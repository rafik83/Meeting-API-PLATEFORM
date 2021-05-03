<script>
  import { _ } from 'svelte-i18n';

  export let name;
  export let checked = false;
  export let errorMessage;
</script>

<div class="my-5">
  <div class="flex flex-row items-center">
    <input
      on:change
      type="checkbox"
      class="form-checkbox h-6 w-10 mr-2"
      name="termsAndCondition"
      bind:checked
    />

    <span />

    <label
      for={name}
      class="block {checked ? 'text-community-300' : 'text-gray-400'}"
    >
      {@html $_('registration.conditions', {
        values: {
          link:
            '<a href="http://example.fr" class="underline" target="_blank">' +
            $_('registration.termsConditions') +
            '</a>',
          link2:
            '<a href="http://example2.fr" class="underline" target="_blank">' +
            $_('registration.policyConditions') +
            '</a>',
        },
      })}
    </label>
  </div>

  {#if errorMessage}
    <p class="text-error mb-4 my-0">{errorMessage}</p>
  {/if}
</div>
