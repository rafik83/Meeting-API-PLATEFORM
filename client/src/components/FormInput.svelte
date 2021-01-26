<style>
  input:focus::placeholder {
    color: transparent;
  }

  input::placeholder {
    font-style: italic;
  }
</style>

<script>
  export let displayLabel = false;

  const handleFocusInput = () => {
    displayLabel = true;
  };

  const handleMouseOut = () => {
    if (!value) {
      displayLabel = false;
    }
  };

  export let name;
  export let type = '';
  export let value = '';
  export let label = '';
  export const required = 'required';

  const className =
    'py-2.5 px-5 w-full text-grey border-2 rounded-3xl border-none';
</script>

<div class="border border-gray-200 my-5 rounded-3xl">
  {#if displayLabel}
    <div>
      <label
        for={label}
        class="block mt-2 text-grey italic absolute bg-gray-50 mf-2.5 -mt-3.5 ml-3 px-2 text-sm"
        >{name}</label
      >
    </div>
  {/if}

  {#if type === 'email'}
    <input
      type="email"
      {required}
      placeholder={label}
      bind:value
      on:focusout={handleMouseOut}
      on:focus={handleFocusInput}
      class={className}
    />
  {:else if type === 'password'}
    <input
      type="password"
      {required}
      placeholder={label}
      bind:value
      on:focusout={handleMouseOut}
      on:focus={handleFocusInput}
      class={className}
    />
  {:else}
    <input
      type="text"
      {required}
      placeholder={label}
      bind:value
      on:focusout={handleMouseOut}
      on:focus={handleFocusInput}
      class={className}
    />
  {/if}
</div>
