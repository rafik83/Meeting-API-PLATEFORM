<script>
  import { _ } from 'svelte-i18n';

  /**
   * @event {FileList} add
   */
  /**
   * Specify the accepted file types
   * @type {string[]}
   */
  export let accept = [];
  /** Set to `true` to allow multiple files */
  export let multiple = false;
  /**
   * Override the default behavior of validating uploaded files
   * The default behavior does not validate files
   * @type {(files: FileList) => FileList}
   */
  export let validateFiles = (files) => files;
  /** Specify the label text */
  // export let labelText = 'Add file';
  /** Specify the `role` attribute of the drop container */
  let role = 'button';
  /** Set to `true` to disable the input */
  export let disabled = false;
  /** Specify `tabindex` attribute */
  let tabindex = '0';
  /** Set an id for the input element */
  let id = 'ccs-' + Math.random().toString(36);
  /** Specify a name attribute for the input */
  export let name = '';
  let ref = null;
  import { createEventDispatcher } from 'svelte';
  const dispatch = createEventDispatcher();
  export let errorMessage = '';
  export let successMessage = '';
  export let loading = false;
</script>

<div
  class="border-dashed flex h-2/5 align-middle items-center flex-col border"
  {...$$restProps}
  on:dragover
  on:dragover|preventDefault|stopPropagation={({ dataTransfer }) => {
    if (!disabled) {
      dataTransfer.dropEffect = 'copy';
    }
  }}
  on:dragleave
  on:dragleave|preventDefault|stopPropagation={({ dataTransfer }) => {
    if (!disabled || loading) {
      dataTransfer.dropEffect = 'move';
    }
  }}
  on:drop
  on:drop|preventDefault|stopPropagation={({ dataTransfer }) => {
    if (!disabled || loading) {
      errorMessage = '';
      successMessage = '';
      dispatch('drop', validateFiles(dataTransfer.files));
    }
  }}
>
  <label
    class="w-full h-full flex flex-col justify-center items-center {loading
      ? 'cursor-not-allowed bg-gray-100'
      : 'cursor-pointer'}"
    for={id}
    {tabindex}
    on:keydown
    on:keydown={({ key }) => {
      if (key === ' ' || (key === 'Enter' && !loading)) {
        ref.click();
      }
    }}>
    {#if loading}
      <p class="text-sm italic">{$_('registration.loading')}</p>
    {:else}
      <p class="underline font-semibold">{$_('registration.upload_logo')}</p>
      <p class="text-community-300 text-sm">{$_('registration.png_jpg')}</p>
    {/if}

    {#if errorMessage}
      <p class="text-error text-sm italic">{errorMessage}</p>
    {/if}
    {#if successMessage}
      <p class="text-success text-sm italic">{successMessage}</p>
    {/if}
    <div {role}>
      <input
        bind:this={ref}
        class="hidden"
        type="file"
        tabindex="-1"
        {id}
        {disabled}
        {accept}
        {name}
        {multiple}
        on:change
        on:change={({ target }) => {
          dispatch('add', validateFiles(target.files));
        }}
        on:click
        on:click={({ target }) => {
          if (!loading) {
            return;
          }
          target.value = null;
        }}
      />
    </div>
  </label>
</div>
