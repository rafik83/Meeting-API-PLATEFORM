<script>
  import { _ } from 'svelte-i18n';
  import { createEventDispatcher } from 'svelte';
  import { getFileUploadReport } from '../modules/fileManagement';

  export let accept = [];

  export let fileMaxSize = 1 * 1024 * 1024;

  export let multiple = false;

  export let disabled = false;

  export let name = '';

  export let successMessage = '';

  export let loading = false;

  let ref = null;

  let role = 'button';

  let tabindex = '0';

  let id = 'ccs-' + Math.random().toString(36);

  const dispatch = createEventDispatcher();
  let validationRepport = [];

  const hasErrors = (errors) => {
    return errors.some((item) => item.hasErrors);
  };

  const handleUploadFile = (files) => {
    // if (!disabled && !loading) {
    //   successMessage = '';
    //   validationRepport = getFileUploadReport(files, accept, fileMaxSize);
    //   if (!hasErrors(validationRepport)) {
    //     dispatch('drop', files);
    //   }
    // }
  };
</script>

<div
  class="border-dashed flex h-2/5 align-middle items-center flex-col border"
  {...$$restProps}
  on:dragover
  on:dragover|preventDefault|stopPropagation={({ dataTransfer }) => {
    dataTransfer.dropEffect = 'copy';
  }}
  on:dragleave
  on:dragleave|preventDefault|stopPropagation={({ dataTransfer }) => {
    dataTransfer.dropEffect = 'move';
  }}
  on:drop
  on:drop|preventDefault|stopPropagation={({ dataTransfer }) => {
    console.log(dataTransfer);
    // handleUploadFile(dataTransfer.files);
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
      if ((key === ' ' || key === 'Enter') && !loading) {
        ref.click();
      }
    }}>
    {#if loading}
      <p class="text-sm italic">{$_('registration.loading')}</p>
    {:else}
      <p class="underline font-semibold">{$_('registration.upload_logo')}</p>
      <p class="text-community-300 text-sm">{$_('registration.png_jpg')}</p>
    {/if}

    {#if hasErrors(validationRepport)}
      {#each validationRepport as { fileName, errors: _errors }}
        <p class="text-sm">{fileName} :</p>
        <p class="text-error mt-2 text-sm italic">
          {$_('validation.import_file_error')}
        </p>
        <ol>
          {#if _errors.maxSizeExceeded}
            <li class="text-sm">{$_('validation.max_size_error')}</li>
          {/if}
          {#if _errors.wrongMimeType}
            <li class="text-sm">{$_('validation.mime_type_error')}</li>
          {/if}
        </ol>
      {/each}
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
        {name}
        {multiple}
        on:change
        on:change={({ target }) => {
          console.log(target);
          // handleUploadFile(target.files);
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
