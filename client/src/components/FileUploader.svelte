<script>
  import {getFileUploadReport} from '../modules/fileManagement';
  import {_} from 'svelte-i18n';
  import {createEventDispatcher} from 'svelte';
  import IconClose from "../ui-kit/icons/IconClose/IconClose.svelte";

  const dispatch = createEventDispatcher();

  export let accept = [];

  export let fileMaxSize = 1 * 1024 * 1024;

  export let loading = false;

  let validationSucceed = false;

  let defaultText = $_('registration.upload_logo');

  let avatar;

  let fileInput;

  let alt;

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

    let image = fileList[0];
    alt = fileList[0].name;
    let reader = new FileReader();
    reader.readAsDataURL(image);
    reader.onload = e => {
      avatar = e.target.result;
    };
  };

  const handleDrop = (event) => {
    validationSucceed = false;
    const dataTransfer = event.dataTransfer;
    handleUploadFile(dataTransfer.files);
  };

  const handleInputChange = ({target}) => {
    handleUploadFile(target.files);
  };

  const handleInputClick = (e) => {
    if (loading) {
      e.preventDefault();
    }
  };

  const deleteClick = () => {
    avatar = '';
  }
</script>

{#if avatar && !hasErrors(validationRepport)}
  <div class="mt-20 mb-5">
    <div class="flex justify-end items-end z-index-10">
        <IconClose fill="#FFF" class="w-5 p-1 bg-community-300 rounded-xl cursor-pointer -mb-5" on:click={deleteClick}/>
    </div>
    <img src="{avatar}" alt="{alt}" class="w-40 h-40 rounded-full border-2 border-gray-50 right-5 bottom-0 object-cover"/>
  </div>
{/if}

<div
  class="md:h-52 h-32 flex w-full border-dashed border-4"
  on:drop|stopPropagation|preventDefault={handleDrop}
  on:dragenter|stopPropagation|preventDefault
  on:dragover|stopPropagation|preventDefault
>
  <label
    class="flex flex-col h-full items-center w-full justify-center {loading
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

    {#if validationSucceed && !loading && avatar}
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
      bind:this={fileInput}
      accept={accept.join(', ')}
      type="file"
      class="hidden"
      tabindex="-1"
    />
  </label>
</div>
