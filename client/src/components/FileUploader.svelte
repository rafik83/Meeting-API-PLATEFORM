<script>
  import { getFileUploadReport } from '../modules/fileManagement';
  import { _ } from 'svelte-i18n';
  import { createEventDispatcher } from 'svelte';

  const dispatch = createEventDispatcher();

  export let accept = [];

  export let fileMaxSize = 1 * 1024 * 1024;

  export let loading = false;

  let validationSucceed = false;

  let defaultText = $_('registration.upload_logo');

  const hasErrors = (errors) => {
    return errors.some((item) => item.hasErrors);
  };

  let validationRepport = [];

  const handleUploadFile = (fileList) => {
    if (loading) {
      return;
    }
    validationSucceed = false;

    validationRepport = getFileUploadReport(fileList, accept, fileMaxSize);

    if (!hasErrors(validationRepport)) {
      validationSucceed = true;
      dispatch('fileUploaded', fileList);
    }
  };

  const handleDrop = (event) => {
    validationSucceed = false;
    const dataTransfer = event.dataTransfer;
    handleUploadFile(dataTransfer.files);
  };

  const handleInputChange = ({ target }) => {
    handleUploadFile(target.files);
  };

  const handleInputClick = (e) => {
    if (loading) {
      e.preventDefault();
    }
    e.value = null;
  };
</script>

<div
  class="md:h-full h-32 flex w-full border-dashed border-4"
  on:drop|stopPropagation|preventDefault={handleDrop}
  on:dragenter|stopPropagation|preventDefault
  on:dragover|stopPropagation|preventDefault
>
  <label
    class="flex flex-col h-full items-center w-full justify-center outlined {loading
      ? 'cursor-not-allowed bg-gray-100'
      : 'cursor-pointer'}"
    tabindex="0"
  >
    {#if loading}
      <p class="text-sm italic">{$_('registration.loading')}</p>
    {:else}
      <slot>
        <p class="underline font-semibold">{defaultText}</p>
        <p class="text-community-300 text-sm">{$_('registration.png_jpg')}</p>
      </slot>
    {/if}

    {#if validationSucceed && !loading}
      <p class="text-success text-sm italic">
        {$_('validation.file_upload_succeed')}
      </p>
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

    <input
      on:change={handleInputChange}
      on:click={handleInputClick}
      accept={accept.join(', ')}
      type="file"
      class="hidden"
      tabindex="-1"
    />
  </label>
</div>
