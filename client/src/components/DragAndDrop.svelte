<script>
  import { _ } from 'svelte-i18n';

  export let accept;
  export let maxSize;
  let fileInput;

  let values = {
    file: '',
  };

  let acceptedFiles = [];
  let rejectedFiles = [];
  let isAcceptedFiles = false;
  let isFileRejected = false;

  function inputFile(e) {
    const files = e.target.files;

    console.log('BEFORE', {
      acceptedFiles,
      rejectedFiles,
      files,
    });

    Object.keys(files).map((file) => {
      if (files[file].size > maxSize) {
        console.log('JE SUIS ICI');
        rejectedFiles = rejectedFiles.push(files[file].name);
        isFileRejected = true;
      } else {
        acceptedFiles = acceptedFiles.push(files[file].name);
        isAcceptedFiles = true;
        isFileRejected = false;
      }
    });

    console.log('AFTER', {
      acceptedFiles,
      rejectedFiles,
      files,
    });
  }

  function uploadFile() {
    console.log('JE SUIS ICI');
    fileInput.click();
  }
</script>

<div
  class="border-dashed flex p-8 align-middle items-center flex-col border cursor-pointer"
  tabindex="0"
  on:click={uploadFile}
>
  <h1 class="underline font-semibold">{$_('registration.upload_logo')}</h1>
  <h2 class="text-community-300 text-sm">{$_('registration.png_jpg')}</h2>
  <input
    {accept}
    type="file"
    bind:this={fileInput}
    autocomplete="off"
    tabindex="-1"
    {maxSize}
    on:click={inputFile}
    bind:value={values.file}
    class="hidden"
  />
  {#if isFileRejected}
    <h3 class="text-sm text-error">Fichier trop lourd</h3>
  {:else if isAcceptedFiles}
    <h3 class="text-sm text-success">Fichier ok</h3>
  {/if}
</div>
